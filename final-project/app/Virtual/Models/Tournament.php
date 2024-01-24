<?php

namespace App\Virtual\Models;

use App\Virtual\Requests\TournamentRequest;

/**
 * @OA\Schema(
 *     title="Tournament",
 *     description="Tournament model",
 *     required={"id"},
 * )
*/
class Tournament extends TournamentRequest
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
}
?>