<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\OrderController;





Route::resource('ingredients',IngredientController::class);
Route::resource('recipes',RecipeController::class);
Route::resource('orders',OrderController::class);
Route::get('company-required-ingredient',[OrderController::class,'companyRequiredIngredient']);


