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
    public function getUsers($request)
    {
        $limit = $request->query('limit', 50);
        $sortField = $request->query('sort_field', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $users = User::orderBy($sortField, $sortOrder)->paginate($limit);
        $users->load('address');
        return $users;
    }

    public function createUser($request)
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

    public function loginUser($request)   
    {
        $user = $this->getUserByEmail($request->email);
        if (!empty($user)) {
            if ($this->checkPassword($request->password, $user->password)) {
                $token = $this->generateToken($user);
                return [
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
        $user->load('address');
        $userFields = ['firstname', 'lastname', 'phone'];
        $addressFields = ['city', 'street', 'zipcode'];
        $userDataToUpdate = array_intersect_key($userData, array_flip($userFields));
        $addressDataToUpdate = array_intersect_key($userData, array_flip($addressFields));
        $user->update($userDataToUpdate);
        if ($user->address) {
            $user->address->update($addressDataToUpdate);
        } else {
            $user->address()->create($addressDataToUpdate);
        }

        return $user;
    }

    public function deleteUser(string $id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            $user->delete();
        }
        return $user;
    }
}
