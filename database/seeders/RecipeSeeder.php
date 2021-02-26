<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('recipes')->insert([
            0 => [
                'name' => 'recipe 1',
                'description' => 'Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel,
                 we recommend reading all of the documentation from beginning to end.'],
            1 => [
                'name' => 'recipe 2',
                'description' => 'Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel,
                 we recommend reading all of the documentation from beginning to end.'],
            2 => [
                'name' => 'recipe 3',
                'description' => 'Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel,
                 we recommend reading all of the documentation from beginning to end.']
         
        ]);

        \DB::table('ingredient_recipe')->insert([
            0 => [
                'recipe_id' => 1,
                'ingredient_id' => 1,
                'amount' => 100],
            1 => [
                'recipe_id' => 1,
                'ingredient_id' => 2,
                'amount' => 4,
            ],
            2 => [
                'recipe_id' => 2,
                'ingredient_id' => 1,
                'amount' => 200
            ],
            3 => [
                'recipe_id' => 3,
                'ingredient_id' => 1,
                'amount' => 150
            ],
            4 => [
                'recipe_id' => 3,
                'ingredient_id' => 3,
                'amount' => 6
            ]
         
        ]);


    }
}
