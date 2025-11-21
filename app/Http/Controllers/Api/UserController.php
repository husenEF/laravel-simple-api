<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:sanctum')->except(['index', 'store']);
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return response()->json($users);
    }

    /**
     * Store a newly created user (POST /api/users)
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = $this->userService->createUser($validated);

            return new UserResource($user);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
