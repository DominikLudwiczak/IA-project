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
        'latitude',
        'longitude',
        'discipline_id',
    ];

    protected $casts = [
        'time' => 'datetime',
        'registrationTime' => 'datetime',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function participants()
    {
      return $this->belongsToMany(User::class, 'tournament_registrations')->using(TournamentRegistration::class)->withTimestamps();
    }

    public function ladders()
    {
        return $this->hasMany(Ladder::class);
    }
}
