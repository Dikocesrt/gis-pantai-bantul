<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLayananRequest;
use App\Http\Requests\UpdateLayananRequest;
use App\Models\Layanan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $layanans->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('layanans.index', compact('layanans'));
    }

    public function store(StoreLayananRequest $request)
    {
        try {
            $file = $request->file('icon');
            $prefix = config('filesystems.disks.cloudinary.prefix');
    
            $folder = $prefix ? "{$prefix}/layanans" : 'layanans';
            $path = Storage::disk('cloudinary')->putFile($folder, $file);

            Layanan::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'icon' => $path,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('layanans.index')
                ->with('success', 'Layanan berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating layanan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('layanans.index')
                ->with('error', 'Gagal menambahkan layanan. Silakan coba lagi.');
        }
    }

    public function update(UpdateLayananRequest $request, $id)
    {
        try {
            $layanan = Layanan::findOrFail($id);

            $data = [
                'name' => $request->name,
                'updated_by' => Auth::id(),
            ];

            if ($request->hasFile('icon')) {
                if ($layanan->icon) {
                    try {
                        Storage::disk('cloudinary')->delete($layanan->icon);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old icon from Cloudinary: ' . $e->getMessage());
                    }
                }

                $file = $request->file('icon');
                $prefix = config('filesystems.disks.cloudinary.prefix');
                $folder = $prefix ? "{$prefix}/layanans" : 'layanans';
                $path = Storage::disk('cloudinary')->putFile($folder, $file);
                
                $data['icon'] = $path;
            }

            $layanan->update($data);

            return redirect()->route('layanans.index')
                ->with('success', 'Layanan berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating layanan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('layanans.index')
                ->with('error', 'Gagal memperbarui layanan. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $layanan = Layanan::findOrFail($id);
            
            if ($layanan->icon) {
                try {
                    Storage::disk('cloudinary')->delete($layanan->icon);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete icon from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $layanan->delete();

            return redirect()->route('layanans.index')
                ->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting layanan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('layanans.index')
                ->with('error', 'Gagal menghapus layanan. Silakan coba lagi.');
        }
    }
}
