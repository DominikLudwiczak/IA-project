<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'time',
        'registration_time',
        'max_participants',
        'ranked_players',
        'latitude',
        'longitude',
        'discipline_id',
    ];

    protected $casts = [
        'time' => 'datetime',
        'registrationTime' => 'datetime',
    ];

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function participants(): BelongsToMany
    {
      return $this->belongsToMany(User::class)->using(TournamentRegistration::class);
    }
}
