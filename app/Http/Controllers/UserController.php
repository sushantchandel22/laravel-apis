<?php
namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Str;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'users' => $users
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "users not found"
            ]);
        }
    }


    public function store(CreateUserRequest $request)
    {
        try {
            $user = User::create($request->all());
            $address = Address::create([
                'user_id' => $user->id,
                'city' => $request->city,
                'street' => $request->street,
                'zipcode' => $request->zipcode,
                'phone' => $request->phone,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]);
            $user->address()->save($address);
            return response()->json([
                'message' => 'User created successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User creation failed',
            ]);
        }
    }



    public function show($id)
    {
        try {
            $user = User::find($id);
            return response()->json([
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User not found'
            ]);
        }
    }


    public function login(LoginUserRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('token')->accessToken;
                    return response()->json([
                        'message' => 'User login successfully',
                        'token' => $token,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Password is incorrect',
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User login failed',
            ]);
        }
    }

    public function loggedIn(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            $user->load('address');
            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User login failed',
            ]);
        }
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->update($request->all());
            return response()->json([
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User updation failed',
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
            return response()->json([
                'message' => 'User updation failed',
            ]);
        }
    }
}


