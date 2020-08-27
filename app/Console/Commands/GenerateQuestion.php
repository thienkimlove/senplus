<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;

class GenerateQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:quest';

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
        $optionStr = 'Ví như một vị bác sĩ lâu năm kinh nghiệm';

        for ($i = 1; $i <7; $i ++) {
            Question::create([
                'name' => $optionStr,
                'option1' => $optionStr,
                'option2' => $optionStr,
                'option3' => $optionStr,
                'option4' => $optionStr,
                'round' => 1,
                'order' => $i,
                'company_id' => 1
            ]);
        }

        for ($i = 1; $i <7; $i ++) {
            Question::create([
                'name' => $optionStr,
                'option1' => $optionStr,
                'option2' => $optionStr,
                'option3' => $optionStr,
                'option4' => $optionStr,
                'round' => 2,
                'order' => $i,
                'company_id' => 1
            ]);
        }
    }
}
