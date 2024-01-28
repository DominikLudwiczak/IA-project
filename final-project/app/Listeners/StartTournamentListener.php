<?php

namespace App\Listeners;

use App\Events\StartTournamentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StartTournamentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StartTournamentEvent $event): void
    {
        $tournament = $event->tournament;

        if ($tournament->ladders()->exists()) {
            return;
        }

        $participants = $tournament->participants->sortBy('id');
        $participantsCount = $participants->count();

        foreach ($participants as $participant1) {
            foreach ($participants->where('id', '>', $participant1->id) as $participant2) {
                $tournament->ladders()->create([
                    'participant1_id' => $participant1->id,
                    'participant2_id' => $participant2->id,
                ]);
            }
        }
    }
}
