<?php

namespace App\Console\Commands;

use App\Helpers;
use App\Models\Post;
use Illuminate\Console\Command;

class MakeContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download Image from Content and Replace';

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
        $post = Post::first();

        $content = Helpers::transformImageContent($post);

        $post->update(['content' =>  $content]);

        $this->line($content);


    }
}
