<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ingredient;
class refill_all extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refill:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refills all ingredient containers';

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
        
        if( $this->laravel->isDownForMaintenance() ){
            $ingredients = Ingredient::all();
            foreach ($ingredients as $ingredient){
                $ingredient->amount = 1000;
                $ingredient->save();
            }
        }else{
            $this->info("This command is only available in maintenance mode");
        }
    }
}
