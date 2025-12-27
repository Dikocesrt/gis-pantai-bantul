<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeTempat extends Model
{
    use SoftDeletes;

    protected $table = 'tipe_tempats';
    
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
