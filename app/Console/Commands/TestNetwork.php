<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestNetwork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:network';

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
     * @return int
     */
    public function handle()
    {
        $url = 'http://shwebank4u.connectnpay.com/api/retrieve.php?env=uat&role=agents';

        for ($i = 0 ; $i < 10 ; $i++) {
            try {
                print_r(file_get_contents($url));
                $this->line("done ".$i);
            } catch (\Exception $exception) {

                $this->line("Error ".$i);
                $this->line($exception->getMessage());

            }

        }
    }
}
