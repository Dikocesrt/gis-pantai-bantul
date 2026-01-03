<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;

    protected $table = 'kecamatans';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'boundary_geojson',
        'color',
        'center_lat',
        'center_lng',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'center_lat' => 'decimal:7',
        'center_lng' => 'decimal:7',
    ];

    public function tempatWisata()
    {
        return $this->hasMany(TempatWisata::class);
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
