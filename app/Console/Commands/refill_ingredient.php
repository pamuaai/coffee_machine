<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class refill_ingredient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refill:ingredient {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refills ingredient to 1000';

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
        //
        if($this->laravel->isDownForMaintenance()){
            $name = $this->argument('name');
            if(!$name){
                $name = $this->ask("Which ingredient container would you like to refill?");
            }
            if(Ingredient::where('name', '=', $name)->exists()){
                $ingredient = Ingredient::where('name', '=', $name)->first();
                $added = 1000 - $ingredient->amount;
                $ingredient->amount = 1000;
                
                
            }else{
                $ingredient = new Ingredient;
                $ingredient->name = $name;
                $ingredient->amount =  1000;
            }
            $this->info("The ".$name." container is full (1000)");
            $ingredient->save();
            $this->info("Added ".$added." measures of ".$name);
            $log = new Log;
            $log->action = "refill";
            $log->item = $name;
            $log->amount = $added;
            $log->save();
            
            //TODO: Ask for input in case of missing arguments
        }else{
            $this->info("This command is only available in maintenance mode");
        }
    }
}
