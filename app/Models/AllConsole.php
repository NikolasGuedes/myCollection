<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllConsole extends Model
{
    use SoftDeletes;
    protected $table = 'all_consoles';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'picture',
    ];

    public function getPictureUrlAttribute()
    {
        if ($this->picture) {
            // Se começar com http/https, é uma URL externa
            if (str_starts_with($this->picture, 'http')) {
                return $this->picture;
            }
            // Caso contrário, é um arquivo local
            return asset('imgs/' . $this->picture);
        }
        return null;
    }
}
