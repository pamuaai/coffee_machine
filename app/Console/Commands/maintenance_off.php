<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
class maintenance_off extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:off';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue artisan command "up"';

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
       $this->call('up');
    }
}
