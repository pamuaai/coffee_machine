<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Recipe;
use App\Ingredient;

class make_drink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:drink {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes the drink specified in the "name" argument';

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
        $name = $this->argument('name');
        //Make a drink
        //If recipe is not specified ask what kind of drink the user wants
        if($name){
            $this->info("Makin' a nice cup o' ".$this->argument('name'));
        }else{
            $name = $this->ask('What drink would you like?');
            $this->info("Makin' a nice cup o' ".$name);
        }

        //Check recipes table if exists
        if(Recipe::where('name', '=', $name)->exists()){
            $recipe = Recipe::where('name', '=', $name)->first();
            //If yes, iterate over ingredients
            foreach( $recipe->toArray() as $key => $value )
            {
                if(!in_array($key, ['id', 'name', 'created_at', 'updated_at', 'water']) && Ingredient::where('name', '=', $key)->exists()){
                    $ing = Ingredient::where('name', '=', $key)->first();
                    if($ing->amount >= $value){
                        $ing->amount = $ing->amount - $value;
                        $ing->save();
                        $this->info("Used ".$value." units of ".$key);
                    }else{
                        $this->info("Not enough ".$key." in machine");
                    }

                }
            }
            //If ingredient amount is not 0, check if amount is available in ingredients table
            //If yes, remove it
        }else{
            $this->info("This recipe is not in the DB");
        }
        
        


    }
}
