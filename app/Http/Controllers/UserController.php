<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $users = User::with('organization')->get();
        if (auth()->user()->role === User::ADMIN_ROLE)
            $users = User::with('organization')
                ->whereIn('role', [User::ADMIN_ROLE, User::TECHNICIAN_ROLE])
                ->where('organization_id', auth()->user()->organization->id)
                ->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->safe()->except(['organization_id']);
        $organization_id = $request->safe()->only(['organization_id']);
        $user = User::create(array_merge(
            $validated,
            ['organization_id' => $organization_id ? $organization_id !== null : auth()->user()->organization_id],
            [
                'last_login_date' => Carbon::now(),
                'login_ip' => '127.0.0.1',
            ],
        ));
        return response()->json([
            'message' => 'New user successfully registered.',
            'user' => array_merge($user->toArray(), ['organization' => $user->organization])
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(array_merge($user->toArray(), ['organization' => $user->organization]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill($validated);
        $user->save();
        return response()->json(array_merge($user->toArray(), ['organization' => $user->organization]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse|null
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['id' => $user->id], 200);
    }
}
