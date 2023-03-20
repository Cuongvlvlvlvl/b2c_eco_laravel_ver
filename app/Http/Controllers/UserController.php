<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getUser(){
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ], 200);
    }
}
