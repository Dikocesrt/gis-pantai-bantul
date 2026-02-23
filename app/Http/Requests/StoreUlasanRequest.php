<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUlasanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tempat_wisata_id' => 'required|uuid|exists:tempat_wisatas,id',
            'name' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'tempat_wisata_id.required' => 'Tempat wisata wajib diisi',
            'tempat_wisata_id.exists' => 'Tempat wisata tidak valid',
            'rating.required' => 'Rating wajib diisi',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'name.max' => 'Nama maksimal 100 karakter',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ];
    }
}
