<?php

use Illuminate\Database\Seeder;
use App\Recipe;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add some recipes
        $rec = new Recipe;
        $rec->name = "espresso";
        $rec->coffee = 20;
        $rec->water = 30;
        $rec->save();

        $rec = new Recipe;
        $rec->name = "latte";
        $rec->coffee = 20;
        $rec->milk = 20;
        $rec->water = 10;
        $rec->save();

        $rec = new Recipe;
        $rec->name = "cappucino";
        $rec->coffee = 20;
        $rec->milk = 10;
        $rec->water = 10;
        $rec->sugar = 10;
        $rec->save();
    }
}
