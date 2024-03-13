<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //login api
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
            'phone' => 'required|numeric|unique:users',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            $apiResource = new ApiResource(false, $validator->errors()->first(), null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
            return $apiResource->toResponse($request);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return new ApiResource(true, 'User created successfully.', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'phone' => $user->phone,
            'address' => $user->address,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201, 'Created', ['WWW-Authenticate' => 'Bearer']);
    }

    //login api
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return new ApiResource(false, 'Invalid credentials.', null, 401, 'Unauthorized', ['WWW-Authenticate' => 'Bearer']);
        }
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return new ApiResource(true, 'User logged in successfully.', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
                'address' => $user->address,
                'token' => $token,
                'token_type' => 'Bearer'
            ], 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
        } else {
            return new ApiResource(false, 'Invalid credentials.', null, 401, 'Unauthorized', ['WWW-Authenticate' => 'Bearer']);
        }
    }

    //logout api
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return new ApiResource(true, 'User logged out successfully.', null, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
    }
}
