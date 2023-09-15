<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterTechnicianRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/admin/users",
     *     summary="Получить список всех пользователей",
     *     tags={"Пользователи"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="email", type="string", example="Some email"),
     *             @OA\Property(property="password", type="string", example="Some password"),
     *             @OA\Property(property="role", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="full_name", type="string", example="Some full name"),
     *             @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="login_ip", type="string", example="Some IP"),
     *             @OA\Property(property="organization_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $users = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $users = User::all();
        if (auth()->user()->role == User::ADMIN_ROLE)
            foreach (User::where('role', User::TECHNICIAN_ROLE)->get() as $user)
                array_push($users, $user->toArray());
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreUserRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/admin/users",
     *     summary="Создание нового пользователя",
     *     tags={"Пользователи"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="name", type="string", example="Some name"),
     *                     @OA\Property(property="email", type="string", example="Some email"),
     *                     @OA\Property(property="password", type="string", example="Some password"),
     *                     @OA\Property(property="password_confirmation", type="string", example="Password confirmation"),
     *                     @OA\Property(property="role", type="integer", example=0),
     *                     @OA\Property(property="status", type="integer", example=0),
     *                     @OA\Property(property="organization_id", type="integer", example=1)
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="New user (technician) successfully registered."),
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
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create(array_merge(
            $validated,
            [
                'last_login_date' => Carbon::now(),
                'login_ip' => '127.0.0.1',
            ],
        ));
        return response()->json([
            'message' => 'New user successfully registered.',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/admin/users/{user}",
     *     summary="Получить данные пользователя",
     *     tags={"Пользователи"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         description="id пользователя",
     *         in="path",
     *         name="user",
     *         required=true,
     *         example=1
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="email", type="string", example="Some email"),
     *             @OA\Property(property="password", type="string", example="Some password"),
     *             @OA\Property(property="role", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="full_name", type="string", example="Some full name"),
     *             @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="login_ip", type="string", example="Some IP"),
     *             @OA\Property(property="organization_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         )
     *     )
     * )
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     *
     * @OA\Put(
     *     path="/api/v1/admin/users/{user}",
     *     summary="Обновить пользователя",
     *     tags={"Пользователи"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         description="id пользователя",
     *         in="path",
     *         name="user",
     *         required=true,
     *         example=1
     *     ),
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="name", type="string", example="Some name for edit"),
     *                     @OA\Property(property="description", type="string", example="Some description for edit"),
     *                     @OA\Property(property="type", type="integer", example=0),
     *                     @OA\Property(property="status", type="integer", example=0),
     *                     @OA\Property(property="technical_system_id", type="integer", example=1)
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="description", type="string", example="Some description"),
     *             @OA\Property(property="type", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="technical_system_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill($validated);
        $user->save();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse|null
     *
     * @OA\Delete(
     *     path="/api/v1/admin/users/{user}",
     *     summary="Удалить пользователя",
     *     tags={"Пользователи"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         description="id пользователя",
     *         in="path",
     *         name="user",
     *         required=true,
     *         example=1
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User was successfully deleted.")
     *         )
     *     )
     * )
     */
    public function destroy(User $user)
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $user->delete();
            return response()->json(['message' => 'User was successfully deleted.'], 200);
        }
        return null;
    }

    /**
     * Register a new User (technician).
     *
     * @param RegisterTechnicianRequest $request
     * @return JsonResponse
     *
     * * @OA\Post(
     *     path="/api/v1/admin/users/register-technician",
     *     summary="Регистрация техника",
     *     tags={"Пользователи"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="name", type="string", example="Some name"),
     *                     @OA\Property(property="email", type="string", example="Some email"),
     *                     @OA\Property(property="password", type="string", example="Some password"),
     *                     @OA\Property(property="password_confirmation", type="string", example="Password confirmation")
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="New user (technician) successfully registered."),
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
    public function registerTechnician(RegisterTechnicianRequest $request) {
        $validated = $request->validated();
        $user = User::create(array_merge(
            $validated,
            [
                'password' => bcrypt($request->password),
                'role' => User::TECHNICIAN_ROLE,
                'status' => User::ACTIVE_STATUS,
                'organization_id' => auth()->user()->organization->id,
                'last_login_date' => Carbon::now(),
                'login_ip' => '127.0.0.1',
            ],
        ));
        return response()->json([
            'message' => 'New user (technician) successfully registered.',
            'user' => $user
        ], 201);
    }
}
