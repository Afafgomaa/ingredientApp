<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;






Route::get('/', [RecipeController::class,'recipesView']);
Route::post('/add-recipe', [RecipeController::class,'store']);


