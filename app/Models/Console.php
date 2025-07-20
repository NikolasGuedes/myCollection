<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Console extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function scopeOfFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($query) use ($filters) {
                $query->where('displayName', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('givenName', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('surname', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
