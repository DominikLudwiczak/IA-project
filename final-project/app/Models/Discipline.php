<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class);
    }
}
