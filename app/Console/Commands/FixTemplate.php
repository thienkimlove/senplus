<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Question;
use App\Models\Template;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run one time to get good example survey question, put to templates.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function createFirstTemplateQuestion()
    {
        $templates = DB::table('templates')->get();

        foreach ($templates as $template) {
            $question = $template->questions;

            if (gettype($question) == 'string') {
                $question = json_decode($question, true);

                Template::find($template->id)->update([
                    'questions' => $question
                ]);

                $this->line('done with id='.$template->id);
            }
        }

        $users = DB::table('customers')->get();

        foreach ($users as $user) {
            $option = $user->options;

            if (gettype($option) == 'string') {
                $option = json_decode($option, true);

                Customer::find($user->id)->update([
                    'options' => $option
                ]);

                $this->line('done with id='.$user->id);
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return 0;
        // find company which not have
        //$this->createFirstTemplateQuestion();

        echo gettype(Customer::find(106)->options);
    }
}
