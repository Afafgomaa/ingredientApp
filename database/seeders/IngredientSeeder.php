<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ingredients')->insert([
            0 => [
                'name' => 'sugar',
                'measure' => 'g',
                'supplier' => 'Ahmed Shop'],
            1 => [
                'name' => 'potatoes',
                'measure' => 'pieces',
                'supplier' => 'Afaf Shop'
            ],
            2 => [
                'name' => 'tomato',
                'measure' => 'pieces',
                'supplier' => 'Mona Shop'
            ]
         
        ]);
    }
}
