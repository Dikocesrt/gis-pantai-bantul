<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKecamatanRequest;
use App\Http\Requests\UpdateKecamatanRequest;
use App\Models\Kecamatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kecamatan.index', compact('kecamatans'));
    }

    public function store(StoreKecamatanRequest $request)
    {
        try {
            Kecamatan::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('kecamatan.index')
                ->with('success', 'Kecamatan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Gagal menambahkan kecamatan. Silakan coba lagi.');
        }
    }

    public function update(UpdateKecamatanRequest $request, $id)
    {
        try {
            $kecamatan = Kecamatan::findOrFail($id);

            $kecamatan->update([
                'name' => $request->name,
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('kecamatan.index')
                ->with('success', 'Kecamatan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Gagal memperbarui kecamatan. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->delete();

            return redirect()->route('kecamatan.index')
                ->with('success', 'Kecamatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Gagal menghapus kecamatan. Silakan coba lagi.');
        }
    }
}
