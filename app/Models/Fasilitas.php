<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use SoftDeletes;

    protected $table = 'fasilitas';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'icon',
        'created_by',
        'updated_by',
    ];

    public function tempatWisata()
    {
        return $this->belongsToMany(TempatWisata::class, 'tempat_fasilitas');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
