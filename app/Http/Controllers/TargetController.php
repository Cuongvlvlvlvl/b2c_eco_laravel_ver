<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class TargetController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getTarget($id){
        
        $uid = auth()->user()->id;

        $type = Target::where([
            ['id', '=', $uid],
            ['idr', '=', $id]
        ])->first();

        return response()->json([
            'status' => 'success',
            'revenue' => $type,
        ], 200);

    }

    public function getAllTargets(){

        $uid = auth()->user()->id;

        $type = Target::where('id', $uid)->get();

        return response()->json([
            'status' => 'success',
            'revenues' => $type,
        ], 200);

    }

    public function createTarget(Request $req){

        $uid = auth()->user()->id;

        try{
            $req->validate([
                'ida' => 'required|numeric',
                'name' => 'required|string',
                'value' => 'required|numeric',
                'adddate' => 'required|date',
            ]);

            $target = Target::create([
                'id' => $uid,
                'ida' => $req->ida,
                'name' => $req->name,
                'value' => $req->value,
                'adddate' => Carbon::parse($req->adddate),
            ])->get()->last();
        } catch(Throwable $ex) {

            return response()->json([
                'status' => 'err',
                'message' => 'bad request',
            ], 400);

        }

        return response()->json([
            'status' => 'success',
            'target' => $target,
        ], 200);

    }

    public function changeTarget($id, $uid, Request $req){
        
        $uidc = auth()->user()->id;

        try{
            $req->validate([
                'ida' => 'required|numeric',
                'name' => 'required|string',
                'value' => 'required|numeric',
            ]);
            if($uid == $uidc){
                $target = Target::where([
                    ['id', '=', $uid],
                    ['idr', '=', $id]
                ])->first();
                $target->ida = $req->ida;
                $target->name = $req->name;
                $target->value = $req->value;
                $target->save();
            } else {
                $today = date('Y-m-d H:i:s');
                $target = Target::create([
                    'id' => $uid,
                    'name' => $req->name,
                    'value' => $req->value,
                    'adddate' => $today,
                ])->get()->last();
            }
        } catch(Throwable $ex) {

            return response()->json([
                'status' => 'err',
                'message' => 'bad request',
            ], 400);

        }

        return response()->json([
            'status' => 'success',
            'target' => $target,
        ], 200);
    }

    public function deleteTarget($id, $uid){

        $uidc = auth()->user()->id;
        if($uidc != $uid){
            return response()->json([
                'status' => 'fail',
                'message' => 'forbidden',
            ], 401);
        } else {
            Target::where([
                ['id', '=', $uid],
                ['idr', '=', $id]
            ])->delete();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'deleted',
        ], 200);

    }
}
