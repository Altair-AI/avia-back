<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Вход в систему",
     *     tags={"Аутентификация"},
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="email", type="string", example="Some email"),
     *                     @OA\Property(property="password", type="string", example="Some password")
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="Generated new token"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Some name"),
     *                 @OA\Property(property="email", type="string", example="Some email"),
     *                 @OA\Property(property="password", type="string", example="Some password"),
     *                 @OA\Property(property="role", type="integer", example=0),
     *                 @OA\Property(property="status", type="integer", example=0),
     *                 @OA\Property(property="full_name", type="string", example="Some full name"),
     *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
     *                 @OA\Property(property="organization_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request) {
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        if (!$token = auth()->attempt($validator->validated()))
            return response()->json(['error' => 'Unauthorized'], 401);
        return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Выход из системы",
     *     tags={"Аутентификация"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User successfully signed out.")
     *         )
     *     )
     * )
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out.']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @return JsonResponse
     */
    protected function createNewToken(string $token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
