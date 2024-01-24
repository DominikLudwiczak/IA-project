<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Discipline",
 *     description="Discipline model",
 *     required={"id", "name"},
 * )
*/
class Discipline
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
     *     title="Name",
     *     description="Name",
     *     example="Football"
     * )
     *
     * @var string
    */
    private $name;
}

?>