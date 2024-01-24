<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="TournamentDetails",
 *     description="TournamentDetails model",
 *     required={"discipline"}
 * )
*/
class TournamentDetails extends Tournament
{
    /**
     * @OA\Property(
     *     title="Discipline",
     *     description="Discipline",
     *     type="object",
     *     ref="#/components/schemas/Discipline"
     * )
     * 
     * @var Discipline
    */
    private $discipline;
}