<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFasilitasRequest;
use App\Http\Requests\UpdateFasilitasRequest;
use App\Models\Fasilitas;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cloudName = config('filesystems.disks.cloudinary.cloud');
        
        $fasilitas->each(function ($item) use ($cloudName) {
            $item->icon_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$item->icon}";
        });

        return view('fasilitas.index', compact('fasilitas'));
    }

    public function store(StoreFasilitasRequest $request)
    {
        try {
            $file = $request->file('icon');
            $prefix = config('filesystems.disks.cloudinary.prefix');
    
            $folder = $prefix ? "{$prefix}/fasilitas" : 'fasilitas';
            $path = Storage::disk('cloudinary')->putFile($folder, $file);

            Fasilitas::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'icon' => $path,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('fasilitas.index')
                ->with('success', 'Fasilitas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('fasilitas.index')
                ->with('error', 'Gagal menambahkan fasilitas. Silakan coba lagi.');
        }
    }

    public function update(UpdateFasilitasRequest $request, $id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);

            $data = [
                'name' => $request->name,
                'updated_by' => Auth::id(),
            ];

            if ($request->hasFile('icon')) {
                if ($fasilitas->icon) {
                    try {
                        Storage::disk('cloudinary')->delete($fasilitas->icon);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to delete old icon from Cloudinary: ' . $e->getMessage());
                    }
                }

                $file = $request->file('icon');
                $prefix = config('filesystems.disks.cloudinary.prefix');
                $folder = $prefix ? "{$prefix}/fasilitas" : 'fasilitas';
                $path = Storage::disk('cloudinary')->putFile($folder, $file);
                
                $data['icon'] = $path;
            }

            $fasilitas->update($data);

            return redirect()->route('fasilitas.index')
                ->with('success', 'Fasilitas berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('fasilitas.index')
                ->with('error', 'Gagal memperbarui fasilitas. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);
            
            if ($fasilitas->icon) {
                try {
                    Storage::disk('cloudinary')->delete($fasilitas->icon);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete icon from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $fasilitas->delete();

            return redirect()->route('fasilitas.index')
                ->with('success', 'Fasilitas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('fasilitas.index')
                ->with('error', 'Gagal menghapus fasilitas. Silakan coba lagi.');
        }
    }
}
