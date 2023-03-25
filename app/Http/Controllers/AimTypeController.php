<?php

namespace App\Http\Controllers;

use App\Models\AimType;
use Illuminate\Http\Request;

class AimTypeController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getTypeName($id){
        $type = AimType::where('ida', $id)->get();
        return response()->json([
            'status' => 'success',
            'AimTypeName' => $type,
        ], 200);
    }

    public function getAllTypes(){
        $type = AimType::all();
        return response()->json([
            'status' => 'success',
            'AllAimTypes' => $type,
        ], 200);
    }
}
