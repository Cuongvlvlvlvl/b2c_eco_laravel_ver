<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Illuminate\Http\Request;
use Throwable;

class SpendingController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getSpending($id){
        
        $uid = auth()->user()->id;

        $type = Spending::where([
            ['id', '=', $uid],
            ['idr', '=', $id]
        ])->first();

        return response()->json([
            'status' => 'success',
            'spending' => $type,
        ], 200);

    }

    public function getAllSpendings(){

        $uid = auth()->user()->id;

        $type = Spending::where('id', $uid)->get();

        return response()->json([
            'status' => 'success',
            'spendings' => $type,
        ], 200);

    }

    public function createSpending(Request $req){

        $uid = auth()->user()->id;

        try{
            $req->validate([
                'idc' => 'required|numeric',
                'name' => 'required|string',
                'value' => 'required|numeric',
                'adddate' => 'required|date',
                'desc' => 'string',
            ]);

            $spending = Spending::create([
                'id' => $uid,
                'idc' => $req->idc,
                'name' => $req->name,
                'value' => $req->value,
                'adddate' => $req->adddate,
                'desc' => $req->desc,
            ])->get()->last();
        } catch(Throwable $ex) {

            return response()->json([
                'status' => 'err',
                'message' => 'bad request',
            ], 400);

        }

        return response()->json([
            'status' => 'success',
            'spending' => $spending,
        ], 200);

    }

    public function changeSpending($id, $uid, Request $req){
        
        $uidc = auth()->user()->id;

        try{
            $req->validate([
                'idc' => 'required|numeric',
                'name' => 'required|string',
                'value' => 'required|numeric',
                'desc' => 'string',
            ]);
            if($uid == $uidc){
                $spending = Spending::where([
                    ['id', '=', $uid],
                    ['idr', '=', $id]
                ])->get()->first();
                $spending->name = $req->name;
                $spending->value = $req->value;
                $spending->desc = $req->desc;
                $spending->save();
            } else {
                $today = date('Y-m-d H:i:s');
                $spending = Spending::create([
                    'id' => $uid,
                    'name' => $req->name,
                    'value' => $req->value,
                    'adddate' => $today,
                    'desc' => $req->desc,
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
            'spending' => $spending,
        ], 200);
    }

    public function deleteSpending($id, $uid){

        $uidc = auth()->user()->id;
        if($uidc != $uid){
            return response()->json([
                'status' => 'fail',
                'message' => 'forbidden',
            ], 401);
        } else {
            Spending::where([
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
