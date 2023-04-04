<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RevenueController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getRevenue($id){
        
        $uid = auth()->user()->id;

        $type = Revenue::where([
            ['idr', '=', $id],
            ['id', '=', $uid]
            ])->first();

        return response()->json([
            'status' => 'success',
            'revenue' => $type,
        ], 200);

    }

    public function getAllRevenues(){

        $uid = auth()->user()->id;

        $type = Revenue::where('id', $uid)->get();

        return response()->json([
            'status' => 'success',
            'revenues' => $type,
        ], 200);

    }

    public function createRevenue(Request $req){

        $uid = auth()->user()->id;

        try{
            $req->validate([
                'name' => 'required|string',
                'value' => 'required|numeric',
                'adddate' => 'required|date',
                'desc' => 'string',
            ]);

            $revenue = Revenue::create([
                'id' => $uid,
                'name' => $req->name,
                'value' => $req->value,
                'adddate' => Carbon::parse($req->adddate),
                'desc' => $req->desc,
            ])->get()->last();

        } catch(Throwable $ex) {

            return $ex;
            // return response()->json([
            //     'status' => 'err',
            //     'message' => 'bad request',
            // ], 400);

        }

        return response()->json([
            'status' => 'success',
            'revenue' => $revenue,
        ], 200);

    }

    public function changeRevenue($id, $uid, Request $req){
        
        $uidc = auth()->user()->id;

        try{
            $req->validate([
                'name' => 'required|string',
                'value' => 'required|numeric',
                'desc' => 'string',
            ]);
            if($uid == $uidc){
                $revenue = Revenue::where([
                    ['id', '=', $uid],
                    ['idr', '=', $id]
                ])->get()->first();
                $revenue->name = $req->name;
                $revenue->value = $req->value;
                $revenue->desc = $req->desc;
                $revenue->save();
            } else {
                $today = date('Y-m-d H:i:s');
                $revenue = Revenue::create([
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
            'revenue' => $revenue,
        ], 200);
    }

    public function deleteRevenue($id, $uid){

        $uidc = auth()->user()->id;
        if($uidc != $uid){
            return response()->json([
                'status' => 'fail',
                'message' => 'forbidden',
            ], 401);
        } else {
            Revenue::where([
                ['id', '=', $uid],
                ['idr', '=', $id]
            ])->delete();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'deleted',
        ], 200);

    }

    public function getRevenueCalc(){
        $uid = auth()->user()->id;
        $result = DB::select("SELECT * FROM revenue WHERE revenue.id = '$uid' ORDER BY revenue.idr DESC LIMIT 7");
        return response()->json([
            'status' => 'success',
            'data' => $result,
        ], 200);
    }
}
