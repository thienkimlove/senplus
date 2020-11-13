<?php

namespace App\Console\Commands;

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
        DB::table('templates')->truncate();

        $questions = Question::where('survey_id', 5)
            ->orderBy('round', 'asc')
            ->orderBy('order', 'asc')
            ->get();

        $questionJson = [];
        foreach ($questions as $question) {
            $questionJson[] = [
                'name' => $question->name,
                'option1' => $question->option1,
                'option2' => $question->option2,
                'option3' => $question->option3,
                'option4' => $question->option4,
            ];
        }

        Template::create([
            'name' => 'Bộ câu hỏi mẫu QuanDM',
            'type' => 0,
            'questions' => json_encode($questionJson, true)
        ]);
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
    }
}
