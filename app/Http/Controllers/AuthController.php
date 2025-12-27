<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_verified) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda belum diverifikasi oleh admin.');
            }

            $request->session()->regenerate();
            
            \Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'session_id' => $request->session()->getId(),
            ]);
            
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register-admin');
    }

    public function registerAdmin(RegisterAdminRequest $request)
    {
        User::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'admin',
            'is_verified' => false,
        ]);

        return redirect()->route('auth.register-success')->with('success', 'Registrasi berhasil. Menunggu verifikasi dari admin.');
    }

    public function registerSuccess()
    {
        return view('auth.register-success');
    }
}
