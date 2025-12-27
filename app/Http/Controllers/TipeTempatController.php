<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipeTempatRequest;
use App\Http\Requests\UpdateTipeTempatRequest;
use App\Models\TipeTempat;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TipeTempatController extends Controller
{
    public function index()
    {
        $tipeTempat = TipeTempat::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $tipeTempat->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('tipe-tempat.index', compact('tipeTempat'));
    }

    public function store(StoreTipeTempatRequest $request)
    {
        try {
            $file = $request->file('icon');
            $prefix = config('filesystems.disks.cloudinary.prefix');
    
            $folder = $prefix ? "{$prefix}/tipe-tempat" : 'tipe-tempat';
            $path = Storage::disk('cloudinary')->putFile($folder, $file);

            TipeTempat::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'icon' => $path,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('tipe-tempat.index')
                ->with('success', 'Tipe tempat berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('tipe-tempat.index')
                ->with('error', 'Gagal menambahkan tipe tempat. Silakan coba lagi.');
        }
    }

    public function update(UpdateTipeTempatRequest $request, $id)
    {
        try {
            $tipeTempat = TipeTempat::findOrFail($id);

            $data = [
                'name' => $request->name,
                'updated_by' => Auth::id(),
            ];

            if ($request->hasFile('icon')) {
                if ($tipeTempat->icon) {
                    try {
                        Storage::disk('cloudinary')->delete($tipeTempat->icon);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old icon from Cloudinary: ' . $e->getMessage());
                    }
                }

                $file = $request->file('icon');
                $prefix = config('filesystems.disks.cloudinary.prefix');
                $folder = $prefix ? "{$prefix}/tipe-tempat" : 'tipe-tempat';
                $path = Storage::disk('cloudinary')->putFile($folder, $file);
                
                $data['icon'] = $path;
            }

            $tipeTempat->update($data);

            return redirect()->route('tipe-tempat.index')
                ->with('success', 'Tipe tempat berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('tipe-tempat.index')
                ->with('error', 'Gagal memperbarui tipe tempat. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $tipeTempat = TipeTempat::findOrFail($id);
            
            if ($tipeTempat->icon) {
                try {
                    Storage::disk('cloudinary')->delete($tipeTempat->icon);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete icon from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $tipeTempat->delete();

            return redirect()->route('tipe-tempat.index')
                ->with('success', 'Tipe tempat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('tipe-tempat.index')
                ->with('error', 'Gagal menghapus tipe tempat. Silakan coba lagi.');
        }
    }
}
