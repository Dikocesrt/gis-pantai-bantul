<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTempatWisataRequest;
use App\Http\Requests\UpdateTempatWisataRequest;
use App\Models\TempatWisata;
use App\Models\Kecamatan;
use App\Models\TipeTempat;
use App\Models\Fasilitas;
use App\Models\Layanan;
use App\Models\WisataImage;
use App\Models\OpeningHours;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TempatWisataController extends Controller
{
    public function index()
    {
        $tempatWisata = TempatWisata::with([
            'kecamatan',
            'tipeTempat',
            'creator',
            'images' => function($query) {
                $query->where('is_primary', true);
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $tempatWisata->each(function ($item) use ($cloudName) {
            if ($item->images->isNotEmpty()) {
                $item->primary_image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->images->first()->path}";
            }
        });

        return view('tempat-wisata.index', compact('tempatWisata'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        $tipeTempats = TipeTempat::orderBy('name')->get();
        $fasilitas = Fasilitas::orderBy('name')->get();
        $layanans = Layanan::orderBy('name')->get();
        
        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $tipeTempats->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });
        
        $fasilitas->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });
        
        $layanans->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('tempat-wisata.create', compact('kecamatans', 'tipeTempats', 'fasilitas', 'layanans'));
    }

    public function store(StoreTempatWisataRequest $request)
    {
        try {
            Log::info('Store method called', ['data' => $request->all()]);
            
            DB::beginTransaction();

            $slug = Str::slug($request->name);
            
            $existingWithSlug = TempatWisata::withTrashed()
                ->where('slug', $slug)
                ->first();
            
            if ($existingWithSlug) {
                if ($existingWithSlug->trashed()) {
                    $existingWithSlug->slug = $slug . '-deleted-' . time();
                    $existingWithSlug->save();
                } else {
                    $slugCount = TempatWisata::withTrashed()
                        ->where('slug', 'like', $slug . '%')
                        ->count();
                    $slug = $slug . '-' . $slugCount;
                }
            }

            Log::info('Creating tempat wisata', ['slug' => $slug]);

            $tempatWisata = TempatWisata::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'address' => $request->address,
                'kecamatan_id' => $request->kecamatan_id,
                'tipe_tempat_id' => $request->tipe_tempat_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'phone' => $request->phone,
                'is_active' => $request->is_active ?? true,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
            
            Log::info('Tempat wisata created', ['id' => $tempatWisata->id]);

            if ($request->has('fasilitas') && is_array($request->fasilitas)) {
                Log::info('Attaching fasilitas', ['count' => count($request->fasilitas)]);
                foreach ($request->fasilitas as $fasilitasId) {
                    $tempatWisata->fasilitas()->attach($fasilitasId, [
                        'id' => (string) Str::uuid(),
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if ($request->has('layanans') && is_array($request->layanans)) {
                Log::info('Attaching layanans', ['count' => count($request->layanans)]);
                foreach ($request->layanans as $layananId) {
                    $tempatWisata->layanans()->attach($layananId, [
                        'id' => (string) Str::uuid(),
                        'price' => $request->layanan_price[$layananId] ?? null,
                        'price_unit' => $request->layanan_price_unit[$layananId] ?? null,
                        'duration' => $request->layanan_duration[$layananId] ?? null,
                        'is_available' => isset($request->layanan_is_available[$layananId]) ? (bool)$request->layanan_is_available[$layananId] : true,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                    ]);
                }
            }

            if ($request->hasFile('images')) {
                Log::info('Uploading images', ['count' => count($request->file('images'))]);
                $prefix = config('filesystems.disks.cloudinary.prefix');
                $folder = $prefix ? "{$prefix}/tempat-wisata" : 'tempat-wisata';
                $primaryIndex = $request->primary_image_index ?? 0;

                foreach ($request->file('images') as $index => $image) {
                    $path = Storage::disk('cloudinary')->putFile($folder, $image);
                    
                    $isPrimary = $index == $primaryIndex;
                    
                    WisataImage::create([
                        'id' => (string) Str::uuid(),
                        'tempat_wisata_id' => $tempatWisata->id,
                        'path' => $path,
                        'caption' => null,
                        'is_primary' => $isPrimary,
                        'created_by' => Auth::id(),
                    ]);
                }
            }

            if ($request->has('opening_hours') && is_array($request->opening_hours)) {
                Log::info('Saving opening hours');
                foreach ($request->opening_hours as $hours) {
                    if (!empty($hours['open_time']) || !empty($hours['close_time']) || !empty($hours['note'])) {
                        OpeningHours::create([
                            'id' => (string) Str::uuid(),
                            'tempat_wisata_id' => $tempatWisata->id,
                            'day_of_week' => $hours['day_of_week'],
                            'open_time' => $hours['open_time'] ?? null,
                            'close_time' => $hours['close_time'] ?? null,
                            'note' => $hours['note'] ?? null,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }
                }
            }

            DB::commit();
            
            Log::info('Transaction committed successfully');

            return redirect()->route('tempat-wisata.index')
                ->with('success', 'Tempat wisata berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating tempat wisata', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorMessage = 'Gagal menambahkan tempat wisata.';
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $errorMessage = 'Nama tempat wisata sudah terdaftar. Silakan gunakan nama lain.';
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function edit($id)
    {
        $tempatWisata = TempatWisata::with(['fasilitas', 'layanans', 'images', 'openingHours'])
            ->findOrFail($id);
        
        $kecamatans = Kecamatan::orderBy('name')->get();
        $tipeTempats = TipeTempat::orderBy('name')->get();
        $fasilitas = Fasilitas::orderBy('name')->get();
        $layanans = Layanan::orderBy('name')->get();
        
        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $tipeTempats->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });
        
        $fasilitas->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });
        
        $layanans->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });
        
        $tempatWisata->images->each(function ($item) use ($cloudName) {
            $item->image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->path}";
        });

        return view('tempat-wisata.edit', compact('tempatWisata', 'kecamatans', 'tipeTempats', 'fasilitas', 'layanans'));
    }

    public function update(UpdateTempatWisataRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $tempatWisata = TempatWisata::findOrFail($id);

            $slug = $tempatWisata->slug;
            if ($request->name !== $tempatWisata->name) {
                $slug = Str::slug($request->name);
                
                $existingWithSlug = TempatWisata::withTrashed()
                    ->where('slug', $slug)
                    ->where('id', '!=', $id)
                    ->first();
                
                if ($existingWithSlug) {
                    if ($existingWithSlug->trashed()) {
                        $existingWithSlug->slug = $slug . '-deleted-' . time();
                        $existingWithSlug->save();
                    } else {
                        $slugCount = TempatWisata::withTrashed()
                            ->where('slug', 'like', $slug . '%')
                            ->where('id', '!=', $id)
                            ->count();
                        $slug = $slug . '-' . $slugCount;
                    }
                }
            }

            $tempatWisata->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'address' => $request->address,
                'kecamatan_id' => $request->kecamatan_id,
                'tipe_tempat_id' => $request->tipe_tempat_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'phone' => $request->phone,
                'is_active' => $request->is_active ?? true,
                'updated_by' => Auth::id(),
            ]);

            if ($request->has('fasilitas')) {
                $fasilitasData = [];
                foreach ($request->fasilitas as $fasilitasId) {
                    $fasilitasData[$fasilitasId] = [
                        'id' => (string) Str::uuid(),
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $tempatWisata->fasilitas()->sync($fasilitasData);
            } else {
                $tempatWisata->fasilitas()->detach();
            }
            
            if ($request->has('layanans')) {
                $layananData = [];
                foreach ($request->layanans as $layananId) {
                    $layananData[$layananId] = [
                        'id' => (string) Str::uuid(),
                        'price' => $request->layanan_price[$layananId] ?? null,
                        'price_unit' => $request->layanan_price_unit[$layananId] ?? null,
                        'duration' => $request->layanan_duration[$layananId] ?? null,
                        'is_available' => isset($request->layanan_is_available[$layananId]) ? (bool)$request->layanan_is_available[$layananId] : true,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                    ];
                }
                $tempatWisata->layanans()->sync($layananData);
            } else {
                $tempatWisata->layanans()->detach();
            }
            
            if ($request->has('set_primary_image') && $request->set_primary_image) {
                $tempatWisata->images()->update(['is_primary' => false]);
                $tempatWisata->images()->where('id', $request->set_primary_image)->update(['is_primary' => true]);
            }

            if ($request->has('delete_images') && is_array($request->delete_images)) {
                foreach ($request->delete_images as $imageId) {
                    $image = WisataImage::find($imageId);
                    if ($image && $image->tempat_wisata_id === $tempatWisata->id) {
                        try {
                            Storage::disk('cloudinary')->delete($image->path);
                        } catch (\Exception $e) {
                            Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
                        }
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('images')) {
                $prefix = config('filesystems.disks.cloudinary.prefix');
                $folder = $prefix ? "{$prefix}/tempat-wisata" : 'tempat-wisata';
                $primaryIndex = $request->primary_image_index ?? null;

                foreach ($request->file('images') as $index => $image) {
                    $path = Storage::disk('cloudinary')->putFile($folder, $image);
                    
                    $isPrimary = $primaryIndex !== null && $index == $primaryIndex;
                    if ($isPrimary) {
                        $tempatWisata->images()->update(['is_primary' => false]);
                    }
                    
                    WisataImage::create([
                        'id' => (string) Str::uuid(),
                        'tempat_wisata_id' => $tempatWisata->id,
                        'path' => $path,
                        'caption' => null,
                        'is_primary' => $isPrimary,
                        'created_by' => Auth::id(),
                    ]);
                }
            }

            if ($request->has('opening_hours') && is_array($request->opening_hours)) {
                $tempatWisata->openingHours()->delete();
                
                foreach ($request->opening_hours as $hours) {
                    if (!empty($hours['open_time']) || !empty($hours['close_time']) || !empty($hours['note'])) {
                        OpeningHours::create([
                            'id' => (string) Str::uuid(),
                            'tempat_wisata_id' => $tempatWisata->id,
                            'day_of_week' => $hours['day_of_week'],
                            'open_time' => $hours['open_time'] ?? null,
                            'close_time' => $hours['close_time'] ?? null,
                            'note' => $hours['note'] ?? null,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('tempat-wisata.index')
                ->with('success', 'Tempat wisata berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating tempat wisata', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorMessage = 'Gagal memperbarui tempat wisata.';
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $errorMessage = 'Nama tempat wisata sudah terdaftar. Silakan gunakan nama lain.';
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $tempatWisata = TempatWisata::findOrFail($id);
            
            foreach ($tempatWisata->images as $image) {
                try {
                    Storage::disk('cloudinary')->delete($image->path);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $tempatWisata->delete();

            DB::commit();

            return redirect()->route('tempat-wisata.index')
                ->with('success', 'Tempat wisata berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus tempat wisata. Silakan coba lagi.');
        }
    }
}
