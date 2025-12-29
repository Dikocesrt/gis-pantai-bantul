<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempatWisata extends Model
{
    use SoftDeletes;

    protected $table = 'tempat_wisatas';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'address',
        'kecamatan_id',
        'tipe_tempat_id',
        'latitude',
        'longitude',
        'phone',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function tipeTempat()
    {
        return $this->belongsTo(TipeTempat::class);
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'tempat_fasilitas');
    }

    public function layanans()
    {
        return $this->belongsToMany(Layanan::class, 'tempat_layanans', 'tempat_wisata_id', 'layanan_id')
            ->withPivot('price', 'price_unit', 'duration', 'is_available');
    }

    public function images()
    {
        return $this->hasMany(WisataImage::class);
    }

    public function openingHours()
    {
        return $this->hasMany(OpeningHours::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
