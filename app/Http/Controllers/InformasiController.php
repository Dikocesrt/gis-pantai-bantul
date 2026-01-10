<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInformasiRequest;
use App\Http\Requests\UpdateInformasiRequest;
use App\Models\Informasi;
use App\Models\TempatWisata;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    public function index()
    {
        $informasis = Informasi::with(['creator', 'updater', 'tempatWisata'])
            ->orderBy('published_at', 'desc')
            ->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $informasis->each(function ($item) use ($cloudName) {
            if ($item->image_path) {
                $item->image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->image_path}";
            }
        });

        return view('informasi.index', compact('informasis'));
    }

    public function create()
    {
        $tempatWisatas = TempatWisata::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('informasi.create', compact('tempatWisatas'));
    }

    public function store(StoreInformasiRequest $request)
    {
        try {
            // Generate slug from title
            $slug = Str::slug($request->title);
            
            // Check if slug exists
            $existingWithSlug = Informasi::withTrashed()
                ->where('slug', $slug)
                ->first();
            
            if ($existingWithSlug) {
                if ($existingWithSlug->trashed()) {
                    $existingWithSlug->slug = $slug . '-deleted-' . time();
                    $existingWithSlug->save();
                } else {
                    $slugCount = Informasi::withTrashed()
                        ->where('slug', 'like', $slug . '%')
                        ->count();
                    $slug = $slug . '-' . $slugCount;
                }
            }

            // Upload image to Cloudinary
            $file = $request->file('image');
            $prefix = config('filesystems.disks.cloudinary.prefix');
            $folder = $prefix ? "{$prefix}/informasi" : 'informasi';
            $imagePath = Storage::disk('cloudinary')->putFile($folder, $file);

            // Create informasi
            $data = [
                'id' => (string) Str::uuid(),
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'content' => $request->content,
                'image_path' => $imagePath,
                'published_at' => now(),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ];

            // Add event fields if is_event is checked
            if ($request->is_event) {
                $data['event_location'] = $request->event_location;
                $data['event_date'] = $request->event_date;
                $data['event_start_time'] = $request->event_start_time;
                $data['event_end_time'] = $request->event_end_time;
                $data['tempat_wisata_id'] = $request->tempat_wisata_id;
            }

            Informasi::create($data);

            return redirect()->route('informasi.index')
                ->with('success', 'Informasi berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating informasi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan informasi. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $informasi = Informasi::with('tempatWisata')->findOrFail($id);
        
        $tempatWisatas = TempatWisata::where('is_active', true)
            ->orderBy('name')
            ->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        if ($informasi->image_path) {
            $informasi->image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$informasi->image_path}";
        }

        return view('informasi.edit', compact('informasi', 'tempatWisatas'));
    }

    public function update(UpdateInformasiRequest $request, $id)
    {
        try {
            $informasi = Informasi::findOrFail($id);

            // Generate slug if title changed
            $slug = $informasi->slug;
            if ($request->title !== $informasi->title) {
                $slug = Str::slug($request->title);
                
                $existingWithSlug = Informasi::withTrashed()
                    ->where('slug', $slug)
                    ->where('id', '!=', $id)
                    ->first();
                
                if ($existingWithSlug) {
                    if ($existingWithSlug->trashed()) {
                        $existingWithSlug->slug = $slug . '-deleted-' . time();
                        $existingWithSlug->save();
                    } else {
                        $slugCount = Informasi::withTrashed()
                            ->where('slug', 'like', $slug . '%')
                            ->where('id', '!=', $id)
                            ->count();
                        $slug = $slug . '-' . $slugCount;
                    }
                }
            }

            $data = [
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'content' => $request->content,
                'updated_by' => Auth::id(),
            ];

            // Handle image upload if new image provided
            if ($request->hasFile('image')) {
                // Delete old image
                if ($informasi->image_path) {
                    try {
                        Storage::disk('cloudinary')->delete($informasi->image_path);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old image from Cloudinary: ' . $e->getMessage());
                    }
                }

                // Upload new image
                $file = $request->file('image');
                $prefix = config('filesystems.disks.cloudinary.prefix');
                $folder = $prefix ? "{$prefix}/informasi" : 'informasi';
                $imagePath = Storage::disk('cloudinary')->putFile($folder, $file);
                
                $data['image_path'] = $imagePath;
            }

            // Handle event fields
            if ($request->is_event) {
                $data['event_location'] = $request->event_location;
                $data['event_date'] = $request->event_date;
                $data['event_start_time'] = $request->event_start_time;
                $data['event_end_time'] = $request->event_end_time;
                $data['tempat_wisata_id'] = $request->tempat_wisata_id;
            } else {
                // Clear event fields if not an event
                $data['event_location'] = null;
                $data['event_date'] = null;
                $data['event_start_time'] = null;
                $data['event_end_time'] = null;
                $data['tempat_wisata_id'] = null;
            }

            $informasi->update($data);

            return redirect()->route('informasi.index')
                ->with('success', 'Informasi berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating informasi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui informasi. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $informasi = Informasi::findOrFail($id);
            
            // Delete image from Cloudinary
            if ($informasi->image_path) {
                try {
                    Storage::disk('cloudinary')->delete($informasi->image_path);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $informasi->delete();

            return redirect()->route('informasi.index')
                ->with('success', 'Informasi berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting informasi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus informasi. Silakan coba lagi.');
        }
    }
}
