<?php

use Illuminate\Database\Seeder;
use App\Ingredient;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fill basic ingredients to 1000
        $ing = new Ingredient;
        $ing->name = "coffee";
        $ing->amount = 1000;
        $ing->save();

        $ing = new Ingredient;
        $ing->name = "sugar";
        $ing->amount = 1000;
        $ing->save();

        $ing = new Ingredient;
        $ing->name = "milk";
        $ing->amount = 1000;
        $ing->save();

        $ing = new Ingredient;
        $ing->name = "water";
        $ing->amount = 1000;
        $ing->save();
    }
}
