<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WisataImage extends Model
{
    use SoftDeletes;

    protected $table = 'wisata_images';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'tempat_wisata_id',
        'path',
        'caption',
        'is_primary',
        'created_by',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function tempatWisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
