<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_recipe extends Model
{
    use HasFactory;
    protected $guard = ['id'];

    protected $table = 'order_recipes';

   
}
