<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeTempat extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function tempatWisata()
    {
        return $this->hasMany(TempatWisata::class);
    }
}
