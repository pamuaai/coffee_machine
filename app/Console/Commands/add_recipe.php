<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Recipe;

class add_recipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:recipe {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Check if in maintenance mode
        if( $this->laravel->isDownForMaintenance() ){

            //Add name (convert to lowercase immediately for consistency)
            $name = strtolower($this->argument('name'));
            if(!$name){
                $name = $this->ask('What is the name of the recipe?');
            }
            
            if(Recipe::where('name', '=', $name)->exists()){
                $recipe = Recipe::where('name', '=', $name)->first();
            }else{
                $recipe = new Recipe;
                $recipe->name = $name;
                $recipe->save();
            }

            //Adding ingredients (convert to lowercase immediately for consistency)
            $ingredient =  strtolower($this->ask("Ingredient name or 'done' to stop adding ingredients: "));
            while($ingredient != 'done'){
                //Gotta check if ingredient column exists
                if(!Schema::hasColumn('recipes', $ingredient)){
                    //If not, add it
                    Schema::table('recipes', function ($table) use ($ingredient) {
                        $table->integer($ingredient)->default(0);
                    });
                    $this->info("Added new ingredient to ingredients table: ".$ingredient);
                }
                //Now get the amount
                $amount = $this->ask("How much ".$ingredient." goes into ".$recipe->name." ?");
                $recipe->$ingredient = $amount;
                $recipe->save();




                $ingredient = $this->ask("Ingredient name or 'done' to stop adding ingredients: ");
            }
            
        }else{
            $this->info("This command is only available in maintenance mode");
        }

    }
}
