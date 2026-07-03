<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
class AuthController extends Controller
{
    public function register(Request $request){
    $role = Role::where('name','LIKE','%user%')->firstorFail();
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'role_id' => $role->id
    ]);
    $token = auth('api')->login($user);

    return response()->json([
        'message' => 'User registered successfully',
        'token' => $token
    ]);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Invalid credentials'], 401);

        }
        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token
        ]);
    }
    public function me(){
        $user = auth('api')->user();
        return response()->json([
            'message'=> 'user profile',
            'data' => $user
        ]);
    }
    public function logout(){
        auth('api')->logout();
        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }
    public function refresh(){
        $token = auth('api')->refresh();
        return response()->json([
            'token' => $token
        ]);
    }
}