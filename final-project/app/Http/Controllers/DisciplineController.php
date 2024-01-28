<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discipline;

class DisciplineController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/disciplines/all",
     *     operationId="allDisciplines",
     *     security={{"bearer_token":{}}},
     *     tags={"Disciplines"},
     *     @OA\Response(response="200",
     *          description="Get all disciplines",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="App\Virtual\Models\Dicipline")
     *          ),
     *     ),
     * )
     */
    public function all(Request $request){        
        $disciplines = Discipline::all();

        return response()->json([
            'status' => 'success',
            'data' => $disciplines,
        ], 200);
    }
}
