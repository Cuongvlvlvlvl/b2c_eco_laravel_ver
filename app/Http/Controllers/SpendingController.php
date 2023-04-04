<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ['ids', '=', $id]
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
                'adddate' => Carbon::parse($req->adddate),
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
                $spending = Spending::where('ids', $id)->update([
                    'idc' => $req->idc,
                    'name' => $req->name,
                    'value' => $req->value,
                    'desc' => $req->desc,
                ]);
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
                ['ids', '=', $id]
            ])->delete();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'deleted',
        ], 200);

    }

    public function getSpendingCalc(){
        $uid = auth()->user()->id;
        $result = DB::select("SELECT category.name as category, SUM(spending.value) as value FROM (SELECT * FROM spending WHERE spending.id= '$uid' ) spending INNER JOIN category ON spending.idc=category.idc GROUP BY category.name");
        return response()->json([
            'status' => 'success',
            'data' => $result,
        ], 200);
    }

    public function getTopSpending(){
        $uid = auth()->user()->id;
        $result = DB::select("SELECT * FROM spending WHERE spending.id = '$uid' ORDER BY spending.ids DESC LIMIT 7");
        return response()->json([
            'status' => 'success',
            'data' => $result,
        ], 200);
    }
}
