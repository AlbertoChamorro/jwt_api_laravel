<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class CustomRunServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's';

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
        // if ($this->confirm('Do you wish to continue?')) {
        // }
        
        // api:gen --routePrefix="api/*" --noResponseCalls';
        $this->call('api:generate', [
            '--routePrefix' => 'api/*',
            '--noResponseCalls' => 'default' 
            ]);
        
        $this->call('serve');
    }
}
