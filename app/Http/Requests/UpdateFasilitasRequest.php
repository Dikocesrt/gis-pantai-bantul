<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFasilitasRequest extends FormRequest
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
                Rule::unique('fasilitas', 'name')->ignore($this->route('id')),
            ],
            'icon' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,svg|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama fasilitas wajib diisi',
            'name.unique' => 'Nama fasilitas sudah terdaftar',
            'icon.file' => 'File harus berupa file yang valid',
            'icon.mimes' => 'Format gambar harus jpeg, jpg, png, gif, webp, atau svg',
            'icon.max' => 'Ukuran gambar maksimal 10 MB',
        ];
    }
}
