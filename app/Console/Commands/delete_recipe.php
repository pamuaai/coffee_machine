<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Recipe;

class delete_recipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:recipe {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes recipe';

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
        if( $this->laravel->isDownForMaintenance() ){
            $name = strtolower($this->argument('name'));
            if(!$name){
                $name = $this->ask('What is the name of the recipe you want to delete?');
            }

            if(Recipe::where('name', '=', $name)->exists()){
                if ($this->confirm('Are you sure you want to delete the recipe for '.$name.'?(y/n)')) {
                    //
                     Recipe::where('name', '=', $name)->first()->delete();
                     $this->info('The recipe for '.$name.' has been deleted from the database');
                }
            }else{
                $this->info('The recipe for '.$name.' does not exist in the database');
            }

        }else{
            $this->info("This command is only available in maintenance mode");
        }
    }
}
