<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class make_drink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drink:make {recipe?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes the drink specified in the "recipe" argument';

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
        $recipe = $this->argument('recipe');
        //Make a drink
        //If recipe is not specified ask what kind of drink the user wants
        if($recipe){
            $this->info("Makin' a nice cup o' ".$this->argument('recipe'));
        }else{
            $recipe = $this->ask('What drink would you like?');
            $this->info("Makin' a nice cup o' ".$recipe);
        }
    }
}
