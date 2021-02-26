<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\recipe;
use App\Models\order_recipe;


class order extends Model
{
    use HasFactory;
    protected $guard = ['id'];

    public function recipeName(){
       return $this->hasManyThrough(recipe::class,order_recipe::class);
    }
    public function recipes()
    {
        return $this->hasMany(order_recipe::class ); 
    }


    // public function getMeasureByIngredientId($ingredientId){
    //     return $this->where('id' ,$ingredientId )->get('Measure');
    // }
      
}
