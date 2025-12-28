<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTempatWisataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Convert time format from H:i:s to H:i if needed
        if ($this->has('opening_hours')) {
            $openingHours = $this->opening_hours;
            foreach ($openingHours as $key => $hours) {
                if (isset($hours['open_time']) && strlen($hours['open_time']) > 5) {
                    $openingHours[$key]['open_time'] = substr($hours['open_time'], 0, 5);
                }
                if (isset($hours['close_time']) && strlen($hours['close_time']) > 5) {
                    $openingHours[$key]['close_time'] = substr($hours['close_time'], 0, 5);
                }
            }
            $this->merge(['opening_hours' => $openingHours]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tempat_wisatas', 'name')
                    ->ignore($this->route('id'))
                    ->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string',
            'address' => 'required|string',
            'kecamatan_id' => 'required|uuid|exists:kecamatans,id',
            'tipe_tempat_id' => 'required|uuid|exists:tipe_tempats,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            
            // Update primary image for existing images
            'set_primary_image' => 'nullable|uuid|exists:wisata_images,id',
            
            // Fasilitas (array of IDs)
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'uuid|exists:fasilitas,id',
            
            // Images (maksimal 5 gambar)
            'images' => 'nullable|array|max:5',
            'images.*' => 'file|mimes:jpeg,jpg,png,gif,webp|max:10240',
            'primary_image_index' => 'nullable|integer|min:0|max:4',
            
            // Delete images
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'uuid|exists:wisata_images,id',
            
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
