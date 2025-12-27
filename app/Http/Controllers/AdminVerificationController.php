<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminVerificationController extends Controller
{
    public function index()
    {
        $pendingAdmins = User::where('is_verified', false)
            ->where('role', 'admin')
            ->get();

        return view('admin.verification.index', [
            'pendingAdmins' => $pendingAdmins,
        ]);
    }

    public function verify(Request $request, $userId)
    {
        $request->validate([
            'verified_by' => ['required', 'uuid', 'exists:users,id'],
        ]);

        $user = User::findOrFail($userId);

        if ($user->is_verified) {
            return redirect()->back()->with('error', 'Admin sudah terverifikasi sebelumnya');
        }

        $user->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => $request->verified_by,
        ]);

        return redirect()->back()->with('success', 'Admin berhasil diverifikasi');
    }

    public function reject(Request $request, $userId)
    {
        $request->validate([
            'reason' => ['required', 'string'],
        ]);

        $user = User::findOrFail($userId);

        if ($user->is_verified) {
            return redirect()->back()->with('error', 'Tidak dapat menolak admin yang sudah terverifikasi');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Registrasi admin ditolak dan dihapus');
    }
}
