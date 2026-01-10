<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInformasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('informasis', 'title')->whereNull('deleted_at'),
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'content' => [
                'required',
                'string',
            ],
            'image' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:10240', // 10MB
            ],
            'is_event' => [
                'nullable',
                'boolean',
            ],
            'event_location' => [
                'nullable',
                'required_if:is_event,1',
                'string',
                'max:255',
            ],
            'event_date' => [
                'nullable',
                'required_if:is_event,1',
                'date',
            ],
            'event_start_time' => [
                'nullable',
                'required_if:is_event,1',
                'date_format:H:i',
            ],
            'event_end_time' => [
                'nullable',
                'required_if:is_event,1',
                'date_format:H:i',
            ],
            'tempat_wisata_id' => [
                'nullable',
                'uuid',
                'exists:tempat_wisatas,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi',
            'title.unique' => 'Judul berita sudah digunakan',
            'title.max' => 'Judul berita maksimal 255 karakter',
            'description.max' => 'Deskripsi singkat maksimal 500 karakter',
            'content.required' => 'Isi berita wajib diisi',
            'image.required' => 'Gambar berita wajib diupload',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 10 MB',
            'event_location.required_if' => 'Lokasi acara wajib diisi untuk berita event',
            'event_date.required_if' => 'Tanggal acara wajib diisi untuk berita event',
            'event_start_time.required_if' => 'Jam mulai wajib diisi untuk berita event',
            'event_end_time.required_if' => 'Jam selesai wajib diisi untuk berita event',
            'tempat_wisata_id.exists' => 'Tempat wisata tidak valid',
        ];
    }
}
