<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\recipe;
use App\Models\order_recipe;
use Carbon\Carbon;

class OrderController extends Controller
{
    

    

    
    public function store(Request $request)
    {
        $current = Carbon::now();
        // add 2 days to the current time
        $two_days_from_now = $current->addDays(2);
        $validator = Validator::make($request->all(), [
            'client_name' => 'required',
            'delivery_date'=> 'required|date|after:'.$two_days_from_now,
            'recipes' => 'required'    
        ]);
        if ($validator->fails()) {
            return response()->json(['code'=>400, 'status'=>'error' , 'error' =>$validator->errors()], 400);
        }
        $order_recipes = json_decode($request->recipes,'true'); // convert to json
        $count_of_recipes = array_sum(array_column($order_recipes,'count')); // get sum count for all recipes
        if (count($order_recipes) > 4  || $count_of_recipes > 4) {  // if count up 4 return error
            return response()->json(['code'=>400, 'status'=>'error' , 'error' =>" Recipes Count Must Be Less Than 5 Items"], 400);
        }
        $order = new order();
        $order->client_name = $request->client_name;
        $order->delivery_date = $request->delivery_date;
        $order->save();
        
   
        foreach($order_recipes as $recipe){
            $recipe_object  = recipe::find($recipe['id']);
            if (!$recipe_object ) { // loop through each recipes if id not found return error
                order::find($order->id)->delete();
                return response()->json(['code'=>400, 'status'=>'error' , 'error' => 'Invalid Recipe Id' ], 400);
            }
           // save in pivot table order + their recipes
            $order_recipe = new order_recipe();
            $order_recipe->order_id  = $order->id;
            $order_recipe->recipe_id = $recipe['id'];
            $order_recipe->recipe_count = $recipe['count'];
            $order_recipe->save();
        }
        $orderCollectRecipes  = \DB::table('orders')
                      ->join('order_recipes', 'order_recipes.order_id', '=' ,'orders.id')
                      ->join('recipes','order_recipes.recipe_id', '=', 'recipes.id')
                      ->select('recipes.*','order_recipes.recipe_count')
                      ->where('orders.id', '=', $order->id)
                      ->orderBy('order_recipes.order_id')
                      ->get(); // get all recipes related to this orders 
        $data = ['order' => $order, 'recipes' => $orderCollectRecipes];
        return response()->json(['code'=>200, 'status'=>'success' , 'data' => $data],200);
        
       
        
    }

    
    public function companyRequiredIngredient()
    {
        $current = Carbon::now();
        $strat = Carbon::parse($current)->format('Y-m-d'); //transform formate
        // add 7 days to the current time
        $end = Carbon::parse($current->addDays(7))->format('Y-m-d');//transform formate

        
        $collect_all_recipes_required  = \DB::table('orders')
        ->whereBetween('orders.delivery_date',[$strat,$end ])
        ->leftjoin('order_recipes', 'order_recipes.order_id', '=' ,'orders.id')
        ->leftjoin('recipes', 'recipes.id', '=','order_recipes.recipe_id')
        ->leftjoin('ingredient_recipe','ingredient_recipe.recipe_id', '=','recipes.id')
        ->leftjoin('ingredients','ingredients.id','=','ingredient_recipe.ingredient_id')
        ->groupBy('ingredient_recipe.ingredient_id')
        ->selectRaw('ingredients.name , sum(order_recipes.recipe_count) * ingredient_recipe.amount as count')
        ->get(); // get all order with their recipes between strat and end date

   

        return response()->json(['code'=>200, 'status'=>'success' , 'data' =>$collect_all_recipes_required],200);

    }

   

    
}
