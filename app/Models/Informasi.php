<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Informasi extends Model
{
    use SoftDeletes;

    protected $table = 'informasis';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'description',
        'content',
        'image_path',
        'event_location',
        'event_date',
        'event_start_time',
        'event_end_time',
        'tempat_wisata_id',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'published_at' => 'datetime',
    ];

    public function tempatWisata()
    {
        return $this->belongsTo(TempatWisata::class);
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
