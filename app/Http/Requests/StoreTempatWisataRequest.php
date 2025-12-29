<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTempatWisataRequest extends FormRequest
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
                Rule::unique('tempat_wisatas', 'name')->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string',
            'address' => 'required|string',
            'kecamatan_id' => 'required|uuid|exists:kecamatans,id',
            'tipe_tempat_id' => 'required|uuid|exists:tipe_tempats,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            
            // Fasilitas (array of IDs)
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'uuid|exists:fasilitas,id',
            
            // Layanan (array of IDs with details)
            'layanans' => 'nullable|array',
            'layanans.*' => 'uuid|exists:layanans,id',
            'layanan_price' => 'nullable|array',
            'layanan_price.*' => 'nullable|integer|min:0',
            'layanan_price_unit' => 'nullable|array',
            'layanan_price_unit.*' => 'nullable|string|max:50',
            'layanan_duration' => 'nullable|array',
            'layanan_duration.*' => 'nullable|string|max:100',
            'layanan_is_available' => 'nullable|array',
            'layanan_is_available.*' => 'nullable|boolean',
            
            // Images (maksimal 5 gambar)
            'images' => 'nullable|array|max:5',
            'images.*' => 'file|mimes:jpeg,jpg,png,gif,webp|max:10240',
            'primary_image_index' => 'nullable|integer|min:0|max:4',
            
            // Opening Hours (7 days)
            'opening_hours' => 'nullable|array',
            'opening_hours.*.day_of_week' => 'required_with:opening_hours|integer|between:0,6',
            'opening_hours.*.open_time' => 'nullable|date_format:H:i',
            'opening_hours.*.close_time' => 'nullable|date_format:H:i',
            'opening_hours.*.note' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tempat wisata wajib diisi',
            'name.unique' => 'Nama tempat wisata sudah terdaftar',
            'address.required' => 'Alamat wajib diisi',
            'kecamatan_id.required' => 'Kecamatan wajib dipilih',
            'kecamatan_id.exists' => 'Kecamatan tidak valid',
            'tipe_tempat_id.required' => 'Tipe tempat wajib dipilih',
            'tipe_tempat_id.exists' => 'Tipe tempat tidak valid',
            'latitude.between' => 'Latitude harus antara -90 dan 90',
            'longitude.between' => 'Longitude harus antara -180 dan 180',
            'images.*.mimes' => 'Format gambar harus jpeg, jpg, png, gif, atau webp',
            'images.*.max' => 'Ukuran gambar maksimal 10 MB',
            'images.max' => 'Maksimal 5 gambar',
        ];
    }
}
