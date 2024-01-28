<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Tournament;
use App\Events\StartTournamentEvent;

class CheckTournamentTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-tournament-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any tournaments are ready to start. If so, fire the StartTournamentEvent.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tournaments = Tournament::where('time', '<=', now())->get();

        foreach ($tournaments as $tournament) {
            event(new StartTournamentEvent($tournament));
        }
    }
}
