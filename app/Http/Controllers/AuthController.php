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
        try {
            $existingEmail = User::withTrashed()->where('email', $request->email)->first();
            if ($existingEmail) {
                if ($existingEmail->trashed()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['email' => 'Email ini pernah terdaftar sebelumnya dan sudah dihapus. Silakan hubungi administrator untuk mengaktifkan kembali akun Anda.']);
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['email' => 'Email sudah terdaftar. Silakan gunakan email lain.']);
                }
            }
            
            $existingPhone = User::withTrashed()->where('phone', $request->phone)->first();
            if ($existingPhone) {
                if ($existingPhone->trashed()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['phone' => 'Nomor HP ini pernah terdaftar sebelumnya dan sudah dihapus. Silakan hubungi administrator untuk mengaktifkan kembali akun Anda.']);
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['phone' => 'Nomor HP sudah terdaftar. Silakan gunakan nomor lain.']);
                }
            }

            User::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'role' => 'admin',
                'is_verified' => false,
            ]);

            return redirect()->route('auth.register-success')->with('success', 'Registrasi berhasil. Menunggu verifikasi dari admin.');
            
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Registration error', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            
            if ($e->getCode() == 23000) {
                if (str_contains($e->getMessage(), 'users_email_unique')) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['email' => 'Email sudah terdaftar. Silakan gunakan email lain.']);
                }
                if (str_contains($e->getMessage(), 'users_phone_unique')) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['phone' => 'Nomor HP sudah terdaftar. Silakan gunakan nomor lain.']);
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
                
        } catch (\Exception $e) {
            \Log::error('Unexpected registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.');
        }
    }

    public function registerSuccess()
    {
        return view('auth.register-success');
    }
}
