<?php

namespace App\Http\Controllers;

use App\Models\Target;
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
            'idt', $id,
            'id', $uid,
            ])->get();

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
                'desc' => 'string',
            ]);

            $target = Target::create([
                'id' => $uid,
                'ida' => $req->ida,
                'name' => $req->name,
                'value' => $req->value,
                'adddate' => $req->adddate,
                'desc' => $req->desc,
            ]);
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
                'desc' => 'string',
            ]);
            if($uid == $uidc){
                $target = Target::where('id', $uid)->first();
                $target->ida = $req->ida;
                $target->name = $req->name;
                $target->value = $req->value;
                $target->desc = $req->desc;
                $target->save();
            } else {
                $today = date('Y-m-d H:i:s');
                $target = Target::create([
                    'id' => $uid,
                    'name' => $req->name,
                    'value' => $req->value,
                    'adddate' => $today,
                    'desc' => $req->desc,
                ]);
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
            $target = Target::where('id', $uid)->first();
            $target->delete();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'deleted',
        ], 200);

    }
}
