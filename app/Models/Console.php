<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Console extends Model
{
    protected $fillable = [
        'name',
        'picture',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
