<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultsTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ladder_id',
        'participant_id',
        'winner_id',
    ];

    public function ladder()
    {
        return $this->belongsTo(Ladder::class);
    }

    public function participant()
    {
        return $this->belongsTo(User::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class);
    }
}
