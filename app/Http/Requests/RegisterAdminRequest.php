<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\User::withTrashed()->where('email', $value)->exists();
                    if ($exists) {
                        $fail('Email sudah terdaftar. Silakan gunakan email lain.');
                    }
                },
            ],
            'phone' => [
                'required', 
                'string', 
                'max:20',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\User::withTrashed()->where('phone', $value)->exists();
                    if ($exists) {
                        $fail('Nomor HP sudah terdaftar. Silakan gunakan nomor lain.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor HP harus diisi',
            'phone.unique' => 'Nomor HP sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ];
    }
}
