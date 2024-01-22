<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tournament;
use App\Models\Discipline;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified']);
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/all",
     *     operationId="allTournaments",
     *     security={{"bearer_token":{}}},
     *     tags={"Tournaments"},
     *     @OA\Response(response="200", description="Get all tournaments", @OA\JsonContent()),
     * )
     */
    public function all(){
        $tournaments = Tournament::paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $tournaments,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/{id}",
     *     operationId="tournamentById",
     *     security={{"bearer_token":{}}},
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Tournament id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get specific tournaments", @OA\JsonContent()),
     * )
     */
    public function getById(Request $request){
        $tournament = Tournament::find($request->id);

        return response()->json([
            'status' => 'success',
            'data' => $tournament,
        ], 200);
    }

    /**
     * @OA\Post(
     *    path="/api/tournaments/create",
     *    operationId="createTournament",
     *    tags={"Tournaments"},
     *    security={{"bearer_token":{}}},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"name", "time", "registration_time", "max_participants", "latitude", "longitude", "discipline_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="time", type="string", format="date-time"),
     *             @OA\Property(property="registration_time", type="string", format="date-time"),
     *             @OA\Property(property="max_participants", type="integer"),
     *             @OA\Property(property="latitude", type="number"),
     *             @OA\Property(property="longitude", type="number"),
     *             @OA\Property(property="discipline_id", type="integer"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Create Tournament", @OA\JsonContent()),
     * )
     */
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|date_format:Y-m-d H:i|after:now',
            'registration_time' => 'required|date_format:Y-m-d H:i|before:time',
            'max_participants' => 'required|integer|min:1',
            'latitude' => 'required|numeric|regex:/^\d+(\.\d{2,})?$/',
            'longitude' => 'required|numeric|regex:/^\d+(\.\d{2,})?$/',
            'discipline_id' => 'required|integer',
        ]);
        
        $time = date('Y-m-d H:i', strtotime($request->time));
        $registration_time = date('Y-m-d H:i', strtotime($request->registration_time));

        $discipline = Discipline::find($request->discipline_id);

        if($discipline)
        {
            Auth::guard('api')->user()->tournaments()->create([
                'name' => $request->name,
                'time' => $time,
                'registration_time' => $registration_time,
                'max_participants' => $request->max_participants,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'discipline_id' => $discipline->id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Tournament created successfully.',
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Tournament not created.',
        ], 400);
    }

    /**
     * @OA\Post(
     *    path="/api/tournaments/edit/{id}",
     *    operationId="editTournament",
     *    security={{"bearer_token":{}}},
     *    tags={"Tournaments"},
     *    @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Tournament id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"name", "time", "registration_time", "max_participants", "latitude", "longitude", "discipline_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="time", type="string", format="date-time"),
     *             @OA\Property(property="registration_time", type="string", format="date-time"),
     *             @OA\Property(property="max_participants", type="integer"),
     *             @OA\Property(property="latitude", type="number"),
     *             @OA\Property(property="longitude", type="number"),
     *             @OA\Property(property="discipline_id", type="integer"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Create Tournament", @OA\JsonContent()),
     * )
     */
    public function edit(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|date_format:Y-m-d H:i|after:now',
            'registration_time' => 'required|date_format:Y-m-d H:i|before:time',
            'max_participants' => 'required|integer|min:1',
            'latitude' => 'required|numeric|regex:/^\d+(\.\d{2,})?$/',
            'longitude' => 'required|numeric|regex:/^\d+(\.\d{2,})?$/',
            'discipline_id' => 'required|integer',
        ]);
        
        $time = date('Y-m-d H:i', strtotime($request->time));
        $registration_time = date('Y-m-d H:i', strtotime($request->registration_time));

        $discipline = Discipline::find($request->discipline_id);

        if($discipline)
        {
            $tournament = Tournament::find($request->id);

            if($tournament)
            {
                $tournament->update([
                    'name' => $request->name,
                    'time' => $time,
                    'registration_time' => $registration_time,
                    'max_participants' => $request->max_participants,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'discipline_id' => $discipline->id,
                ]);
        
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tournament updated successfully.',
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Tournament not updated.',
        ], 400);
    }
}
