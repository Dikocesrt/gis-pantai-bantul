<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatLayanan extends Model
{
    protected $table = 'tempat_layanans';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'tempat_wisata_id',
        'layanans_id',
        'price',
        'price_unit',
        'duration',
        'is_available',
        'created_by',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_available' => 'boolean',
    ];

    public function tempatWisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanans_id');
    }
}
