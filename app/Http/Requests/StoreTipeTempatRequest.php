<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTipeTempatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tipe_tempats', 'name')->whereNull('deleted_at'),
            ],
            'icon' => 'required|file|mimes:jpeg,jpg,png,gif,webp,svg|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tipe tempat wajib diisi',
            'name.unique' => 'Nama tipe tempat sudah terdaftar',
            'icon.required' => 'Icon tipe tempat wajib diupload',
            'icon.file' => 'File harus berupa file yang valid',
            'icon.mimes' => 'Format gambar harus jpeg, jpg, png, gif, webp, atau svg',
            'icon.max' => 'Ukuran gambar maksimal 10 MB',
        ];
    }
}
