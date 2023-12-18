<?php

namespace App\Http\Controllers;

use App\Http\Filters\WorkSessionFilter;
use App\Http\Requests\WorkSession\IndexWorkSessionRequest;
use App\Models\User;
use App\Models\WorkSession;
use App\Http\Requests\WorkSession\StoreWorkSessionRequest;
use App\Http\Requests\WorkSession\UpdateWorkSessionRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class WorkSessionController extends Controller
{
    /**
     * Create a new WorkSessionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(WorkSession::class, 'work_session');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexWorkSessionRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexWorkSessionRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(WorkSessionFilter::class, ['queryParams' => array_filter($validated)]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $work_sessions = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $work_sessions = WorkSession::filter($filter)->paginate($pageSize);
        if (auth()->user()->role == User::ADMIN_ROLE) {
            // Поиск всех пользователей, принадлежащих к той же организации, что и администратор
            $users = User::whereOrganizationId(auth()->user()->organization_id)->get();
            // Формирование массива id найденных пользователей
            $user_ids = [];
            foreach ($users as $user)
                array_push($user_ids, $user->id);
            // Поиск всех рабочих сессий пользователей удовлетворяющих фильтру
            $work_sessions = WorkSession::filter($filter)->whereIn('user_id', $user_ids)->paginate($pageSize);
        }
        $data = [];
        foreach ($work_sessions as $work_session)
            array_push($data, array_merge($work_session->toArray(), ['user' => $work_session->user]));
        $result['data'] = $data;
        $result['page_current'] = !is_array($work_sessions) ? $work_sessions->currentPage() : null;
        $result['page_total'] = !is_array($work_sessions) ? $work_sessions->lastPage() : null;
        $result['page_size'] = !is_array($work_sessions) ? $work_sessions->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkSessionRequest $request
     * @return JsonResponse
     */
    public function store(StoreWorkSessionRequest $request)
    {
        $validated = $request->validated();
        $work_session = WorkSession::create($validated);
        return response()->json($work_session);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkSession $work_session
     * @return JsonResponse
     */
    public function show(WorkSession $work_session)
    {
        return response()->json(array_merge($work_session->toArray(), [
            'user' => $work_session->user
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkSessionRequest $request
     * @param WorkSession $work_session
     * @return JsonResponse
     */
    public function update(UpdateWorkSessionRequest $request, WorkSession $work_session)
    {
        $validated = $request->validated();
        $work_session->fill($validated);
        $work_session->save();
        return response()->json($work_session);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkSession $work_session
     * @return JsonResponse
     */
    public function destroy(WorkSession $work_session)
    {
        $work_session->delete();
        return response()->json(['id' => $work_session->id], 200);
    }
}
