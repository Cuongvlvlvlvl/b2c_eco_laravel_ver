<?php

namespace App\Http\Controllers;

use App\Models\Dept;
use Illuminate\Http\Request;
use Throwable;

class DeptController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getDept($id){
        
        $uid = auth()->user()->id;

        $type = Dept::where([
            'idc', $id,
            'id', $uid,
            ])->get();

        return response()->json([
            'status' => 'success',
            'dept' => $type,
        ], 200);

    }

    public function getAllDepts(){

        $uid = auth()->user()->id;

        $type = Dept::where('id', $uid)->get();

        return response()->json([
            'status' => 'success',
            'depts' => $type,
        ], 200);

    }

    public function createDept(Request $req){

        $uid = auth()->user()->id;

        try{
            $req->validate([
                'name' => 'required|string',
                'value' => 'required|numeric',
                'valuepertime' => 'required|numeric',
                'adddate' => 'required|date',
                'desc' => 'string',
            ]);

            $dept = Dept::create([
                'id' => $uid,
                'name' => $req->name,
                'value' => $req->value,
                'valuepertime' => $req->valuepertime,
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
            'dept' => $dept,
        ], 200);

    }

    public function changeDept($id, $uid, Request $req){
        
        $uidc = auth()->user()->id;

        try{
            $req->validate([
                'name' => 'required|string',
                'value' => 'required|numeric',
                'valuepertime' => 'required|numeric',
                'desc' => 'string',
            ]);
            if($uid == $uidc){
                $dept = Dept::where('id', $uid)->first();
                $dept->name = $req->name;
                $dept->value = $req->value;
                $dept->valuepertime = $req->valuepertime;
                $dept->desc = $req->desc;
                $dept->save();
            } else {
                $today = date('Y-m-d H:i:s');
                $dept = Dept::create([
                    'id' => $uid,
                    'name' => $req->name,
                    'value' => $req->value,
                    'valuepertime' => $req->valuepertime,
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
            'dept' => $dept,
        ], 200);
    }

    public function deleteDept($id, $uid){

        $uidc = auth()->user()->id;
        if($uidc != $uid){
            return response()->json([
                'status' => 'fail',
                'message' => 'forbidden',
            ], 401);
        } else {
            $dept = Dept::where('id', $uid)->first();
            $dept->delete();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'deleted',
        ], 200);

    }
}
