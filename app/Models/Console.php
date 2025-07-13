<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Console extends Model
{
    protected $fillable = [
        'name',
        'picture',
        'status',
        'user_id',
    ];

    protected $appends = ['picture_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPictureUrlAttribute()
    {
        if ($this->picture) {
            return Storage::url($this->picture);
        }
        return null;
    }
}
