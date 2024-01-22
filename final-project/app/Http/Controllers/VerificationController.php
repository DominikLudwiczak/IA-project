<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/email/verify/{id}",
     *     operationId="verifyEmail",
     *     tags={"VerifyEmail"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="expires",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="hash",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="signature",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\Response(response="200", description="Send email verification link to the user", @OA\JsonContent()),
     * )
     */
    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status' => 'error',
                "message" => "Invalid/Expired url provided.
            "], 401);
        }
    
        $user = User::findOrFail($user_id);

        if($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'success',
                "message" => "Email already verified."
            ], 200);
        }
    
        $user->markEmailAsVerified();

        return response()->json([
            'status' => 'success',
            "message" => "Email verification completed!"
        ], 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/email/resend",
     *     operationId="resendVerificationEmail",
     *     tags={"VerifyEmail"},
     *     @OA\Response(response="200", description="Resend email verification link to the user", @OA\JsonContent()),
     * )
     */
    public function resend() {
        if (Auth::guard('api')->user()->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'success',
                "message" => "Email already verified."
            ], 200);
        }
    
        Auth::guard('api')->user()->sendEmailVerificationNotification();
    
        return response()->json([
            'status' => 'success',
            "message" => "Email verification link sent on your email id"
        ], 200);
    }
}
