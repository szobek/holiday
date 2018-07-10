<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class buildDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:db {dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build database from scratch with dev data';

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

        /*$dev = $this->argument('dev');


        Artisan::call('migrate:fresh');
        Artisan::call('migrate', ['--path' =>'database/migrations/add_permission']);
        Artisan::call('migrate', ['--path' => 'database/migrations/add_workhours']);
        Artisan::call('migrate', ['--path' => 'database/migrations/messages']);
        Artisan::call('migrate', ['--path' => 'database/migrations/update_table']);



        if($dev === "true") {
            Artisan::call('db:seed');
            Artisan::call('db:seed', ['--class' => 'DevelopmentSeeder']);
        }*/


    }
}
