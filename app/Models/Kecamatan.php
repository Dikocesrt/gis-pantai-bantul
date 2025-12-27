<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'created_by',
        'updated_by',
    ];

    public function tempatWisata()
    {
        return $this->hasMany(TempatWisata::class);
    }
}
