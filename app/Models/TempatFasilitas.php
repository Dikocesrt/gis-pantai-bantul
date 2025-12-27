<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatFasilitas extends Model
{
    protected $table = 'tempat_fasilitas';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tempat_wisata_id',
        'fasilitas_id',
        'created_by',
    ];

    public function tempatWisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}
