<?php

namespace App\Http\Controllers;

use App\Models\ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredients = ingredient::paginate(20);
        return response()->json(['code'=>200, 'status'=>'success' , 'data' => $ingredients ],200);
    }

    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'measure'=> 'required',
            'supplier' => 'required'    
        ]);
        if ($validator->fails()) {
            return response()->json(['code'=>400, 'status'=>'error' , 'error' =>$validator->errors()], 400);
        }
        if(! in_array($request->measure, ['g', 'kg', 'pieces'])){
            return response()->json(['code'=>400, 'status'=>'error' , 'error' => 'you must specify Measure Unit From g, kg, pieces '], 400);
        }
        $ingredient = new ingredient();
        $ingredient->name = $request->name;
        $ingredient->measure = $request->measure;
        $ingredient->supplier = $request->supplier;
        $ingredient->save();
        return response()->json(['code'=>200, 'status'=>'success' , 'data' => $ingredient ],200);

        
       
    }

  
    
}
