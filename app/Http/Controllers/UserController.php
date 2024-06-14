<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getUsers();
            return response()->json([
                "success" => true,
                "data" => UserResource::collection($users),
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                "success" => false,
                "message" => "users not found"
            ]);
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $users = $this->userService->createUser($request);
            return response()->json([
                'status' => "true",
                'message' => 'User created successfully',

            ]);
        } catch (\Throwable $th) {
            \Log::error('error=' . $th->getMessage());
            return response()->json([
                "status" => false,
                'message' => 'User creation failed'
            ]);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getSingleUser($id);
            return new UserResource($user);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'ststus' => false,
                'message' => 'User not found'
            ]);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $user = $this->userService->loginUser($request);
            return response()->json([
                'status' => true,
                'message' => 'User login successfully',
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'User login failed',

            ]);
        }
    }

    public function getUser(Request $request)
    {
        try {
            $user = $this->userService->loggedInUser($request);
            return new UserResource($user);
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        try {
            $result = $this->userService->updateUser($request->all(), $userId);
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'user' => $result
            ]);
        } catch (\Exception $e) {
            \Log::error('error' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the user.',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function destroy(string $id)
    {
        try {
            $result = $this->userService->deleteUser($id);
            return response()->json([
                'status' => true,
                "message" => "User deleted successfully"
            ]);
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'User deletion failed',
            ]);
        }
    }
}
