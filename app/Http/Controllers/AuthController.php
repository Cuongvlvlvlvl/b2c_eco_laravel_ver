<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Environment\Console;
use Throwable;

class AuthController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $req){
        $req->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $req->only('username', 'password');
        $token = Auth::attempt($credentials);
        if(!$token) {
            return response()->json([
                'status' => 'err',
                'message' => 'forbidden',
            ], 403);
        }
        $user = Auth::user();
        return response()->json(['token' => $token], 200);
    }

    public function register(Request $req){
        try {
            $validated = $req->validate([
                'username' => 'required|string|unique:user,username',
                'password' => 'required|string',
                'name' => 'string',
                'email' => 'string|email',
            ]);
            $user = User::create([
                'username' => $req->username,
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);
        } catch(Throwable $ex) {
            return response()->json([
                'status' => 'err',
                'message' => 'forbidden',
            ], 403);
        }
        $token = Auth::login($user);
        return response()->json(['token' => $token], 200);
    }
}
