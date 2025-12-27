<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        \Log::info('CheckRole middleware', [
            'authenticated' => Auth::check(),
            'user' => Auth::user()?->email,
            'role' => Auth::user()?->role,
            'required_roles' => $roles,
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            \Log::warning('User not authenticated, redirecting to login');
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has required role
        if (!in_array($user->role, $roles)) {
            \Log::warning('User role not authorized', ['user_role' => $user->role, 'required' => $roles]);
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
