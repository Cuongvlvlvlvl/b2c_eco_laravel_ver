<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getCateName($id){
        $type = Category::where('idc', $id)->get();
        return response()->json([
            'status' => 'success',
            'CategoryName' => $type,
        ], 200);
    }

    
    public function getAllCates($id){
        $type = Category::all();
        return response()->json([
            'status' => 'success',
            'AllCategories' => $type,
        ], 200);
    }
}
