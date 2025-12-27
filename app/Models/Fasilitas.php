<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'created_by',
        'updated_by',
    ];

    public function tempatWisata()
    {
        return $this->belongsToMany(TempatWisata::class, 'tempat_fasilitas');
    }
}
