<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Ladder;
use App\Models\ResultsTemp;
use App\Models\Tournament;
use App\Virtual\Requests\LadderRateRequest;

class LadderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified']);
    }

    /**
     * @OA\Get(
     *     path="/api/ladder/{tournamentId}",
     *     operationId="ladderForTournament",
     *     security={{"bearer_token":{}}},
     *     tags={"Ladder"},
     *     @OA\Parameter(
     *         name="tournamentId",
     *         in="path",
     *         description="Tournament id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200",
     *          description="Get ladder for giver tournament",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="App\Virtual\Models\Ladder")
     *          ),
     *     ),
     * )
     */
    public function ladderForTournament(Request $request, $tournamentId){
        $tournament = Tournament::with('ladders')->whereId($tournamentId)->first();
        if(!$tournament){
            return response()->json([
                'status' => 'error',
                'message' => 'Tournament not found',
            ], 404);
        }

        $ladder = $tournament->ladders()->with(['participant1', 'participant2'])->get();
        $user_id = Auth::guard('api')->user()->id;

        return response()->json([
            'status' => 'success',
            'data' => $ladder,
        ], 200);
    }

    /**
     * @OA\Post(
     *    path="/api/ladder/{ladderId}",
     *    operationId="rateLadder",
     *    tags={"Ladder"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *         name="ladderId",
     *         in="path",
     *         description="Ladder id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="App\Virtual\Requests\LadderRateRequest"),
     *    ),
     *    @OA\Response(response="200", description="Rate Ladder", @OA\JsonContent()),
     * )
     */
    public function rateLadder(LadderRateRequest $request, $ladderId) {
        $request = $request->validated();

        $ladder = Ladder::with(['tournament', 'participant1', 'participant2'])->whereId($ladderId)->first();

        if(!$ladder){
            return response()->json([
                'status' => 'error',
                'message' => 'Ladder not found',
            ], 404);
        }

        $user = Auth::guard('api')->user();
        
        if($ladder->participant1_id != $user->id && $ladder->participant2_id != $user->id){
            return response()->json([
                'status' => 'error',
                'message' => 'You are not participating in this tournament',
            ], 403);
        }

        if($ladder->winner_id != null){
            return response()->json([
                'status' => 'error',
                'message' => 'Game already rated',
            ], 403);
        }

        $resultTemp = ResultsTemp::where('ladder_id', $ladder->id)->first();

        if($resultTemp && $resultTemp->participant_id == $user->id){
            return response()->json([
                'status' => 'error',
                'message' => 'You already rated this game',
            ], 403);
        }

        if($resultTemp)
        {
            $winner = $resultTemp->winner_id;
            $resultTemp->delete();

            if($winner != $request['winner_id'])
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Game was rated in different way by your oponent! Provide proper result again.',
                ], 403);
            } else {
                if($ladder->participant1_id == $user->id){
                    $ladder->winner_id = $ladder->participant1_id;
                } else {
                    $ladder->winner_id = $ladder->participant2_id;
                }
                $ladder->save();
            }
        } else {
            $resultTemp = new ResultsTemp();
            $resultTemp->ladder_id = $ladder->id;
            $resultTemp->participant_id = $user->id;
            $resultTemp->winner_id = $request['winner_id'];
            $resultTemp->save();
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Game rated correctly.',
        ], 200);
    }
}
