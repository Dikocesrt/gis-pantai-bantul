<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKecamatanRequest extends FormRequest
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
                Rule::unique('kecamatans', 'name')->ignore($this->route('kecamatan')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kecamatan wajib diisi',
            'name.string' => 'Nama kecamatan harus berupa teks',
            'name.max' => 'Nama kecamatan maksimal 255 karakter',
            'name.unique' => 'Nama kecamatan sudah terdaftar',
        ];
    }
}
