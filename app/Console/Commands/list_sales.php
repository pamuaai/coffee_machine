<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Log;
use App\Recipe;

class list_sales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:sales';

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
        //
        $this->info($ret);

        $lastMaintenance = Log::where('action', '=', 'refill')->orderBy('id', 'DESC')->first();
        $recipes = Recipe::all();
        foreach ($recipes as $recipe){
            //Get number 'make'-s of this recipe since lastMaintenance
            //Then multiply ingredients with number
            $count = Log::where([
                ['action', '=', 'make'], 
                ['item', '=', $recipe->name]
                ])->get()->count();
            if($count > 0){

                $this->info("Made ".$count." cups of ".$recipe->name." using:");
                foreach( $recipe->toArray() as $key => $value ){
                    if(!in_array($key, ['id', 'name', 'created_at', 'updated_at']) && $value > 0){
                        $this->info($value*$count." units of ".$key);
                    }
                }
            }
        }
    }
}
