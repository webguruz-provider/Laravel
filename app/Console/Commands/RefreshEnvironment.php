<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'sided:refresh';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Refresh my local env';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $this->call('migrate:refresh');
        $this->info('Database Refreshed!');
        $this->call('db:seed');
        $this->info('Database Seeded!');
    }
}
