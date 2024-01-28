<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ladder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'participant1_id',
        'participant2_id',
        'winner_id',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participant1()
    {
        return $this->belongsTo(User::class);
    }

    public function participant2()
    {
        return $this->belongsTo(User::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class);
    }
}
