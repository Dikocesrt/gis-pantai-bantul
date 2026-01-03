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
                Rule::unique('kecamatans', 'name')
                    ->ignore($this->route('kecamatan'))
                    ->whereNull('deleted_at'),
            ],
            'boundary_file' => [
                'nullable',
                'file',
                'mimes:json,geojson',
                'max:10240', // 10MB
            ],
            'color' => [
                'nullable',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'center_lat' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],
            'center_lng' => [
                'nullable',
                'numeric',
                'between:-180,180',
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
            'boundary_file.file' => 'File boundary harus berupa file',
            'boundary_file.mimes' => 'File boundary harus berformat .json atau .geojson',
            'boundary_file.max' => 'Ukuran file boundary maksimal 10MB',
            'color.regex' => 'Format warna harus HEX (contoh: #10b981)',
            'center_lat.numeric' => 'Latitude harus berupa angka',
            'center_lat.between' => 'Latitude harus antara -90 sampai 90',
            'center_lng.numeric' => 'Longitude harus berupa angka',
            'center_lng.between' => 'Longitude harus antara -180 sampai 180',
        ];
    }
}
