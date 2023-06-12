<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['login']]);
    }
    //___index
    public function index()
    {
        return response()->json(User::all());
    }
    //___Register
    public function register(Request $request)
    {
        $rulse = [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ];
        $validator = Validator::make($request->all(), $rulse);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json(["Data" => $request->all()]);
    }
    //___login
    public function login(Request $request)
    {
        $rulse = [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ];
        $validator = Validator::make($request->all(), $rulse);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if (!$token = Auth::attempt($validator->validated())) {
            return response()->json(["Invalid" => "email or password not matched!"]);
        }
        $user = Auth::user();

        // Generate the token with an expiration time
        $token = JWTAuth::fromUser($user, ['expires_in' => config('jwt.ttl')]);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60, // The total expiration time in seconds
            'user' => $user,
        ]);
    }
    //___Refresh token 
    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json([
            'new_token' => $token,
        ]);
    }
    //___Logout and destroy token
    public function logout()
    {
        // Invalidate the current token
        JWTAuth::parseToken()->invalidate();

        // Log out the user
        Auth::logout();

        return response()->json(['message' => 'User logged out successfully']);
    }
}
