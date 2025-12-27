<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFasilitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:fasilitas,name',
            'icon' => 'required|file|mimes:jpeg,jpg,png,gif,webp,svg|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama fasilitas wajib diisi',
            'name.unique' => 'Nama fasilitas sudah terdaftar',
            'icon.required' => 'Icon fasilitas wajib diupload',
            'icon.file' => 'File harus berupa file yang valid',
            'icon.mimes' => 'Format gambar harus jpeg, jpg, png, gif, webp, atau svg',
            'icon.max' => 'Ukuran gambar maksimal 10 MB',
        ];
    }
}
