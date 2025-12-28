<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLayananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $layananId = $this->route('id');
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($layananId) {
                    $exists = \App\Models\Layanan::withTrashed()
                        ->where('name', $value)
                        ->where('id', '!=', $layananId)
                        ->exists();
                    if ($exists) {
                        $fail('Nama layanan sudah terdaftar. Silakan gunakan nama lain.');
                    }
                },
            ],
            'icon' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,svg|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama layanan wajib diisi',
            'name.max' => 'Nama layanan maksimal 255 karakter',
            'icon.mimes' => 'Format icon harus jpeg, jpg, png, gif, webp, atau svg',
            'icon.max' => 'Ukuran icon maksimal 10 MB',
        ];
    }
}
