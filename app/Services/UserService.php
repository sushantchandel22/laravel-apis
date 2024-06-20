<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Auth;

class UserService
{
    public function getUsers()
    {
        $limit = 50;
        $sortField = 'id';
        $sortOrder = 'desc';
        $users = User::with('address')->orderBy($sortField, $sortOrder)->paginate($limit);
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
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('token')->accessToken;
                
                return [  
                    'token' => $token,
                    'user' => $user
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


    public function loggedInUser(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->load('address');
        return $user;
    }

    public function updateUser(array $userData, $userId)
    {
        $user = User::with('address')->findOrFail($userId);

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
        return User::findOrFail($id)->delete();
    }
}
