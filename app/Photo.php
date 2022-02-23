<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'album_id',
        'url',
        'thumbnailUrl',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
