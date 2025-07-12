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

    /**
     * Get the user that owns the console.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
