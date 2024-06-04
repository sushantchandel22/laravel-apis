<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\User;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;
use Str;
use Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userService->getUsers($request);
            return UserResource::collection($users);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                "message" => "users not found"
            ]);
        }
    }


    public function store(CreateUserRequest $request)
    {
        try {
            $users = $this->userService->createUser($request);
            return response()->json([
                'message' => 'User created successfully',
            ]);
        } catch (\Throwable $th) {
            \Log::error('error=' . $th->getMessage());
            return response()->json([
                'message' => 'User creation failed',
            ]);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getSingleUser($id);
            return new UserResource($user);
        } catch (\Throwable $th) {
            \Log::error('error'.$th->getMessage());
            return response()->json([
                'message' => 'User not found'
            ]);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $user = $this->userService->loginUser($request);
            return response()->json([
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return response()->json([
                'message' => 'User login failed',

            ]);
        }
    }

    public function getUser(Request $request)
    {
        try {
            $user = $this->userService->loggedinUser($request);
            return new UserResource($user);
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return response()->json([
                'message' => 'User login failed',
            ]);
        }
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $result = $this->userService->updateUser($request->all(), $userId);

        if ($result['success']) {
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $result['user']
            ], 200);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if (!empty($user)) {
                $user->delete();
                return response()->json([
                    'message' => 'User deleted successfully',
                ]);
            }
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return response()->json([
                'message' => 'User updation failed',
            ]);
        }
    }
}


