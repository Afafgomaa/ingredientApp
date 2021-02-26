<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\recipe;
use App\Models\ingredient;
use App\Models\ingredient_recipe;




class RecipeController extends Controller
{
    
    public function index()
    {
       
        $recipes  = recipe::with('ingredients')->paginate(20);
        
        return response()->json(['code'=>200, 'status'=>'success' , 'data' => $recipes ],200);
    }

   

   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description'=> 'required',
            'ingredients' => 'required'    
        ]);
        if ($validator->fails()) {
            return response()->json(['code'=>400, 'status'=>'error' , 'error' =>$validator->errors()], 400);
        }
        $recipe = new recipe();
        $recipe->name = $request->name;
        $recipe->description = $request->description;
        $recipe->save();

       // conver to json 
        $recipe_ingredients = json_decode($request->ingredients);
        // loop through ingredients
        foreach($recipe_ingredients as $recipe_ingredient){
            $ingredient  = ingredient::find($recipe_ingredient->id);
            if (!$ingredient) { // if id not found return error
                recipe::find($recipe->id)->delete();
                return response()->json(['code'=>400, 'status'=>'error' , 'error' => 'invalid ingredient Id' ], 400);
            }
            $recipeIng = new ingredient_recipe(); // save in pivot table
            $recipeIng->recipe_id = $recipe->id;
            $recipeIng->ingredient_id = $ingredient->id;
            $recipeIng->amount = $recipe_ingredient->amount . " " . $ingredient->unit;
            $recipeIng->save();
        }
        

        return response()->json(['code'=>200, 'status'=>'success' , 'data' => 'Your Recipe Created Successfuly' ],200);

    }

    public function recipesView(){
        $recipes     = recipe::paginate(20);
        $ingredients = ingredient::all();
        return view('welcome')->with(['recipes' => $recipes, 'ingredients' => $ingredients]);
    }

      
  


}
