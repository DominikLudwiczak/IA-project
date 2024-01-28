<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

use App\Models\Tournament;
use App\Models\Discipline;
use App\Virtual\Requests\TournamentRequest;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified'])->except(['all', 'getById']);
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/all",
     *     operationId="allTournaments",
     *     security={{"bearer_token":{}}},
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="filterName",
     *         in="query",
     *         description="Filter by name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200",
     *          description="Get all tournaments",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="App\Virtual\Models\Tournament")
     *          ),
     *     ),
     * )
     */
    public function all(Request $request){
        $currentPage = $request->page ?? 1;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $tournaments = Tournament::where('name', 'like', "%$request->filterName%")->orderBy('time')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $tournaments,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/get/{id}",
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
     *     @OA\Response(
     *          response="200",
     *          description="Get specific tournaments",
     *          @OA\JsonContent(ref="App\Virtual\Models\TournamentDetails"),
     *     ),
     * )
     */
    public function getById($id){
        $tournament = Tournament::with('discipline')->whereId($id)->first();
        $tournament->numOfRankedParticipants = $tournament->participants()->where('rank', '!=', null)->count();

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
     *        @OA\JsonContent(ref="App\Virtual\Requests\TournamentRequest"),
     *    ),
     *    @OA\Response(response="200", description="Create Tournament", @OA\JsonContent()),
     * )
     */
    public function create(TournamentRequest $request){
        $request = $request->validated();
        
        $time = date('Y-m-d H:i', strtotime($request['time']));
        $registration_time = date('Y-m-d H:i', strtotime($request['registration_time']));

        $discipline = Discipline::find($request['discipline_id']);

        if($discipline)
        {
            Auth::guard('api')->user()->tournaments()->create($request);
    
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
     * @OA\Put(
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
     *        @OA\JsonContent(ref="App\Virtual\Requests\TournamentRequest"),
     *    ),
     *    @OA\Response(response="200", description="Create Tournament", @OA\JsonContent()),
     * )
     */
    public function edit(TournamentRequest $request, $id){
        $request = $request->validated();
        
        $time = date('Y-m-d H:i', strtotime($request['time']));
        $registration_time = date('Y-m-d H:i', strtotime($request['registration_time']));

        $discipline = Discipline::find($request['discipline_id']);

        if($discipline)
        {
            $tournament = Tournament::find($id);

            if($tournament)
            {
                $tournament->update($request);
                $tournament->save();
        
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tournament updated successfully.',
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => "Something went wrong. Tournament not updated.",
        ], 400);
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/organizing",
     *     operationId="allTournamentsOrganizing",
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
     *          description="Get all tournaments taht user is organizing",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="App\Virtual\Models\Tournament")
     *         ),
     *     ),
     * )
     */
    public function organizing(Request $request){
        $user = Auth::guard('api')->user();

        $currentPage = $request->page ?? 1;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $tournaments = $user->tournaments()->orderBy('time')->paginate(10);

        return response()->json([
            'status' => 'sucess',
            'data' => $tournaments,
        ], 200);
    }
}
