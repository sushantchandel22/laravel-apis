<?php

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Auth;

class UserService
{
    public function getUsers(Request $request)
    {
        $limit = $request->query('limit', 10);
        $sortField = $request->query('sort_field', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $users = User::orderBy($sortField, $sortOrder)->paginate($limit);
        $users->load('address');
        return $users;
    }

    public function createUser(CreateUserRequest $request)
    {
        $user = User::create($request->all());
        $address = Address::create(array_merge($request->all(), ['user_id' => $user->id]));
        $user->address()->save($address);
        return $user;
    }

    public function getSingleUser($id)
    {
        $user = User::with('address')->findOrFail($id);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
    }

    public function loginUser(LoginUserRequest $request)
    {
        $user = $this->getUserByEmail($request->email);
        if (!empty($user)) {
            if ($this->checkPassword($request->password, $user->password)) {
                $token = $this->generateToken($user);
                return [
                    'message' => 'User login successfully',
                    'token' => $token,
                ];
            } else {
                return [
                    'message' => 'Password is incorrect',
                ];
            }
        } else {
            return [
                'message' => 'User not found',
            ];
        }
    }
    private function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    private function checkPassword($password, $hashedPassword)
    {
        return Hash::check($password, $hashedPassword);
    }

    private function generateToken($user)
    {
        return $user->createToken('token')->accessToken;
    }
    public function loggedinUser(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->load('address');
        return $user;
    }

    public function updateUser(array $userData, $userId)
    {
        $user = User::findOrFail($userId);

        try {
            $user->update($userData);
            return ['success' => true, 'user' => $user];
        } catch (\Throwable $th) {
            \Log::error('ERROR :' . $th->getMessage());
            return ['success' => false, 'message' => 'User updation failed'];
        }
    }
}
