<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\Tournament;

class TournamentRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified']);
    }

    /**
     * @OA\Post(
     *    path="/api/tournaments/register/{id}",
     *    operationId="registerForTournament",
     *    tags={"Tournaments"},
     *    @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Tournament id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *    ),
     *    security={{"bearer_token":{}}},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"rank", "license"},
     *             @OA\Property(property="rank", type="integer"),
     *             @OA\Property(property="license", type="string"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Registered for Tournament", @OA\JsonContent()),
     * )
     */
    public function register(Request $request, $id){
        $request->validate([
            'rank' => 'required|integer|min:1',
            'license' => 'required|string|max:255',
        ]);

        $tournament = Tournament::find($id);

        if(!$tournament){
            return response()->json([
                'status' => 'error',
                'message' => 'This tournament does not exist.',
            ], 400);
        }

        $user = Auth::guard('api')->user();

        if($user->takingpart()->where('tournament_id', $tournament->id)->exists()){
            return response()->json([
                'status' => 'error',
                'message' => 'You are already registered for this tournament.',
            ], 400);
        }

        if($tournament->registration_time < now()){
            return response()->json([
                'status' => 'error',
                'message' => 'The registration time for this tournament has passed.',
            ], 400);
        }

        if($tournament->max_participants <= $tournament->participants()->count()){
            return response()->json([
                'status' => 'error',
                'message' => 'This tournament is already full.',
            ], 400);
        }

        $tournament->participants()->attach($user, [
            'rank' => $request->rank,
            'license' => $request->license,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully registered for this tournament.',
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/participating",
     *     operationId="allTournamentsParticipating",
     *     security={{"bearer_token":{}}},
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Get all tournaments that user is taking part in",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="App\Virtual\Models\Tournament")
     *         ),
     *     ),
     * )
     */
    public function participating(Request $request){
        $user = Auth::guard('api')->user();

        $currentPage = $request->page ?? 1;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $tournaments = $user->takingpart()->paginate(10);

        return response()->json([
            'status' => 'sucess',
            'data' => $tournaments,
        ], 200);
    }
}
