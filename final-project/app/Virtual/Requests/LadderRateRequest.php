<?php

namespace App\Virtual\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="LadderRateRequest",
 *      description="Rate the game in given ladder",
 *      type="object",
 *      required={"winner_id"},
 * )
 */
class LadderRateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="WinnerId",
     *      description="Winner id",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $winner_id;

    public function rules()
    {
        return [
            'winner_id' => 'required|integer',
        ];
    }
}

?>