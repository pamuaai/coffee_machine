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

            if(Ingredient::where('name', '=', $this->argument('i_name'))->exists()){
                $ingredient = Ingredient::where('name', '=', $this->argument('i_name'))->first();
                $added = 1000 - $ingredient->amount;
                $ingredient->amount = 1000;
                
                
            }else{
                $ingredient = new Ingredient;
                $ingredient->name = $this->argument('i_name');
                $ingredient->amount =  1000;
            }
            $this->info("The ".$this->argument('i_name')." container is full (1000)");
            $ingredient->save();
            $this->info("Added ".$added." measures of ".$this->argument('i_name'));
            $log = new Log;
            $log->action = "refill";
            $log->item = $this->argument('i_name');
            $log->amount = $added;
            $log->save();
            
            //TODO: Ask for input in case of missing arguments
        }else{
            $this->info("This command is only available in maintenance mode");
        }
    }
}
