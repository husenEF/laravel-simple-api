<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\QueryParameter;


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
    #[QueryParameter('page', description: 'The page number for pagination.', type: 'int', default: 1, example: 1)]
    #[QueryParameter('search', description: 'A search term to filter results.', type: 'string', example: 'keyword')]
    #[QueryParameter('sortBy', description: 'The field to sort the results by. The Allowed fields: name, email, created_at ', type: 'string', default: 'created_at', example: 'name')]
    #[QueryParameter('sortDir', description: 'The direction to sort the results. Allowed values: asc, desc', type: 'string', default: 'asc', example: 'desc')]
    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request);

        return UserResource::collection($users)
            ->additional([
                'page' => $users->currentPage(),
            ]);
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
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
