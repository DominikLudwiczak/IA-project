<?php

namespace App\Virtual\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="TournamentRequest",
 *      description="Store Tournament request body data",
 *      type="object",
 *      required={"name", "time", "registration_time", "max_participants", "latitude", "longitude", "discipline_id"},
 * )
 */
class TournamentRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the tournament",
     *      example="A nice tournament"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Time",
     *      description="Time of the tournament",
     *      example="2021-05-05 12:00",
     *      format="date-time"
     * )
     *
     * @var string
     */
    public $time;

    /**
     * @OA\Property(
     *      title="Registration time",
     *      description="Registration time of the tournament",
     *      example="2021-05-05 12:00",
     *      format="date-time"
     * )
     *
     * @var string
     */
    public $registration_time;

    /**
     * @OA\Property(
     *      title="Max participants",
     *      description="Max participants of the tournament",
     *      example="10"
     * )
     *
     * @var integer
     */
    public $max_participants;

    /**
     * @OA\Property(
     *      title="Latitude",
     *      description="Latitude of the tournament",
     *      example="52.123456"
     * )
     *
     * @var double
     */
    public $latitude;

    /**
     * @OA\Property(
     *      title="Longitude",
     *      description="Longitude of the tournament",
     *      example="4.123456"
     * )
     *
     * @var double
     */
    public $longitude;

    /**
     * @OA\Property(
     *      title="Discipline id",
     *      description="Discipline id of the tournament",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $discipline_id;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'time' => 'required|date_format:Y-m-d H:i|after:now',
            'registration_time' => 'required|date_format:Y-m-d H:i|before:time|after:now',
            'max_participants' => 'required|integer|min:1',
            'latitude' => 'required|numeric|regex:/^\d+(\.\d{2,})?$/',
            'longitude' => 'required|numeric|regex:/^\d+(\.\d{2,})?$/',
            'discipline_id' => 'required|integer',
        ];
    }
}

?>