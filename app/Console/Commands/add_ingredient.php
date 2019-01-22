<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facade\Facade;
use Illuminate\Console\Command;
use App\Ingredient;

class add_ingredient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:ingredient {i_name} {i_amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if ingredient is in DB, if so, add amount to value in DB if not, add new ingredient to db, with amount';

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
        // $this->info($this->argument('i_name')."-".$this->argument('i_amount'));
        //Should later only work in maintenance mode
        if($this->laravel->isDownForMaintenance()){

            if(Ingredient::where('name', '=', $this->argument('i_name'))->exists()){
                $ingredient = Ingredient::where('name', '=', $this->argument('i_name'))->first();
                $ingredient->amount = $this->argument('i_amount') + $ingredient->amount;
                if($ingredient->amount > 1000){
                    $ingredient->amount = 1000;
                    $this->info("The ".$this->argument('i_name')." container is full (1000)");
                }
            }else{
                $ingredient = new Ingredient;
                $ingredient->name = $this->argument('i_name');
                $ingredient->amount =  $this->argument('i_amount');
            }
            $ingredient->save();
            $this->info("Added ".$this->argument('i_amount')." measures of ".$this->argument('i_name'));
            
            //TODO!: LOG EVERYTHING!
            
            //TODO: Ask for input in case of missing arguments
        }else{
            $this->info("This command is only available in maintenance mode");
        }
    }
}
