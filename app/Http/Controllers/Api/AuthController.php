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
        ]);
        if ($validator->fails()) {
            $apiResource = new ApiResource(false, $validator->errors()->first(), null);
            return $apiResource->toResponse($request);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return new ApiResource(true, 'User created successfully.', [
            'user' => $user,
            'token' => $token
        ]);
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
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        } else {
            return new ApiResource(false, 'Invalid credentials.', null, 401, 'Unauthorized', ['WWW-Authenticate' => 'Bearer']);
        }
    }

    //logout api
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return new ApiResource(true, 'User logged out successfully.', null);
    }
}
