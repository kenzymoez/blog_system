<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Exception;
class AuthController extends Controller
{
    public function register(Request $request){
        try{
            //inline validation
        $validated = $request->validate([
            "name" => 'required|string|max:50',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|string|min:8'
        ]);

            $role = Role::where('name','LIKE','%user%')->firstorFail();
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role_id' => $role->id
            ]);
            $token = auth('api')->login($user);
        }catch(Exception $e){
            return response()->json(['exception' =>$e->getMessage()]);
        }
        return response()->json([
        'message' => 'User registered successfully',
        'token' => $token,
        ],201);
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