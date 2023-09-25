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
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $users = User::all();
        if (auth()->user()->role == User::ADMIN_ROLE) {
            array_push($users, User::find(auth()->user()->id)->toArray());
            $models = User::where([
                ['role', User::TECHNICIAN_ROLE],
                ['organization_id', auth()->user()->organization->id]
            ])->get();
            foreach ($models as $model)
                array_push($users, $model->toArray());
        }
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
