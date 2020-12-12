<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf';

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
        exec("chromehtml2pdf --out /var/www/html/senplus/public/uploads/test.pdf --landscape=1 --executablePath=/usr/bin/chromium-browser https://casonline.vn/uploads/page.html");
    }
}
