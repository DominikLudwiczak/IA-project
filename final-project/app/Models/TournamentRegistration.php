<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TournamentRegistration extends Pivot
{
    use HasFactory;

    protected $table = 'tournament_registrations';

    protected $fillable = [
        'rank',
        'license',
    ];
}
