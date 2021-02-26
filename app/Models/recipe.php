<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ingredient;
use App\Models\ingredient_recipe;


class recipe extends Model
{
    use HasFactory;
    protected $guard = ['id'];

   

    public function getPivot(){
        
        return $this->hasMany(ingredient_recipe::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(ingredient::class,ingredient_recipe::class)->withPivot('amount');
    }

    
    
}
