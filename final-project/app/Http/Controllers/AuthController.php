<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * @OA\Post(
     *    path="/api/register",
     *    operationId="register",
     *    tags={"Authentication"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"name", "email", "password"},
     *             @OA\Property(property="firstName", type="string"),
     *             @OA\Property(property="lastName", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Register", @OA\JsonContent()),
     * )
     */
    public function register(Request $request){
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully. Confirm your email to activate your account.',
        ]);
    }

    /**
     * @OA\Post(
     *    path="/api/login",
     *    operationId="login",
     *    tags={"Authentication"},
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *            type="object",
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="string"),
     *            @OA\Property(property="password", type="string"),
     *          ),
     *       ),
     *    ),
     *    @OA\Response(response="200", description="Login", @OA\JsonContent()),
     * )
    */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
                'status' => 'success',
                'token' => $token,
            ]);

    }

    /**
     * @OA\Post(
     *    path="/api/logout",
     *    operationId="logout",
     *    security={{"bearer_token":{}}},
     *    tags={"Authentication"},
     *    @OA\Response(response="200", description="Logout", @OA\JsonContent()),
     * )
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);
    }

    /**
     * @OA\Post(
     *    path="/api/reset",
     *    operationId="resetPassword",
     *    tags={"Password"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"email"},
     *             @OA\Property(property="email", type="string"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Send email with reset password link", @OA\JsonContent()),
     * )
     */
    public function resetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? response()->json([
                        'status' => 'success',
                        'message' => __($status)
                    ], 200)
                    : response()->json([
                        'status' => 'error',
                        'message' => 'Email could not be sent to this email address'
                    ], 400);
    }

    /**
     * @OA\Post(
     *    path="/api/reset-password",
     *    operationId="resetPasswordStore",
     *    tags={"Password"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"token", "email", "password", "password_confirmation"},
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Reset password", @OA\JsonContent()),
     * )
     */
    public function resetPassword_store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? response()->json([
                        'status' => 'success',
                        'message' => __($status)
                    ], 200)
                    : response()->json([
                        'status' => 'error',
                        'message' => 'Password reset failed.'
                    ], 400);
    }

    /**
     * @OA\Post(
     *    path="/api/change-password",
     *    operationId="changePassword",
     *    security={{"bearer_token":{}}},
     *    tags={"Password"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             type="object",
     *             required={"current_passsword", "password", "password_confirmation"},
     *             @OA\Property(property="current_passsword", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string"),
     *          ),
     *        ),
     *    ),
     *    @OA\Response(response="200", description="Change password", @OA\JsonContent()),
     * )
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $user = Auth::guard('api')->user();
     
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password does not match!'
            ], 400);
        }
     
        $user->password = Hash::make($request->password);
        $user->save();
     
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.'
        ], 200);
    }
}
