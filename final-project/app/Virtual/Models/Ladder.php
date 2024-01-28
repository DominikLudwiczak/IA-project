<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Ladder",
 *     description="Ladder model",
 *     required={"id", "tournament", "participant1", "participant2", "winner_id"},
 * )
*/
class Ladder
{
    /**
     * @OA\Property(
     *     title="Id",
     *     description="Id",
     *     example=1
     * )
     *
     * @var integer
    */
    private $id;

    /**
     * @OA\Property(
     *     title="Tournament",
     *     description="Tournament",
     *     type="object",
     *     ref="#/components/schemas/Tournament"
     * )
     *
     * @var Tournament
    */
    private $tournament;

    /**
     * @OA\Property(
     *     title="Participant1",
     *     description="Participant 1",
     *     type="object",
     *     ref="#/components/schemas/User"
     * )
     *
     * @var User
    */
    private $participant1;

    /**
     * @OA\Property(
     *     title="Participant2",
     *     description="Participant 2",
     *     type="object",
     *     ref="#/components/schemas/User"
     * )
     *
     * @var User
    */
    private $participant2;

    /**
     * @OA\Property(
     *     title="WinnerId",
     *     description="Winner id",
     *     example=1
     * )
     *
     * @var integer
    */
    private $winner_id;
}

?>