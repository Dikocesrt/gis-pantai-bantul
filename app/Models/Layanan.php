<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    protected $table = 'layanans';

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
        return $this->belongsToMany(TempatWisata::class, 'tempat_layanans', 'layanan_id', 'tempat_wisata_id')
            ->withPivot('price', 'price_unit', 'duration', 'is_available');
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
