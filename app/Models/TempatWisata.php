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
        'website',
        'facebook',
        'instagram',
        'tiktok',
        'safety_level',
        'cleanliness_level',
        'road_accessibility',
        'wave_condition',
        'shade_comfort',
        'environment_comfort',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    // Constants for dropdown options
    const SAFETY_LEVELS = [
        'aman' => 'Aman',
        'cukup_aman' => 'Cukup Aman',
        'kurang_aman' => 'Kurang Aman',
    ];

    const CLEANLINESS_LEVELS = [
        'bersih' => 'Bersih',
        'cukup_bersih' => 'Cukup Bersih',
        'kurang_bersih' => 'Kurang Bersih',
    ];

    const ROAD_ACCESSIBILITY = [
        'mudah_diakses' => 'Mudah Diakses',
        'cukup_mudah' => 'Cukup Mudah',
        'sulit_diakses' => 'Sulit Diakses',
    ];

    const WAVE_CONDITIONS = [
        'tenang' => 'Tenang',
        'sedang' => 'Sedang',
        'besar' => 'Besar',
    ];

    const SHADE_COMFORT = [
        'banyak_teduh' => 'Banyak Pohon Teduh',
        'cukup_teduh' => 'Cukup Teduh',
        'minim_teduh' => 'Minim Teduh',
        'tidak_ada_teduh' => 'Tidak Ada Teduh',
    ];

    const ENVIRONMENT_COMFORT = [
        'nyaman' => 'Nyaman',
        'cukup_nyaman' => 'Cukup Nyaman',
        'kurang_nyaman' => 'Kurang Nyaman',
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
