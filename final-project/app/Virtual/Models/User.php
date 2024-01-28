<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     required={"id", "firstName", "lastName", "email",},
 * )
*/
class User
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
     *     title="FirstName",
     *     description="First name",
     *     example="John"
     * )
     *
     * @var string
    */
    private $firstName;

    /**
     * @OA\Property(
     *     title="LastName",
     *     description="Last name",
     *     example="Smith"
     * )
     *
     * @var string
    */
    private $lastName;


    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email",
     *     example="john.smith@gamil.com"
     * )
     *
     * @var string
    */
    private $email;
}

?>