<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionImport implements ToCollection
{
    public $surveyId;

    public function __construct($surveyId)
    {
        $this->surveyId = $surveyId;
    }

    public function collection(Collection $rows)
    {
        $listOldQuestionIds = Question::where('survey_id', $this->surveyId)
            ->pluck('id')
            ->all();

        if ($listOldQuestionIds) {
            Answer::whereIn('question_id', $listOldQuestionIds)->delete();
        }

        Question::where('survey_id', $this->surveyId)->delete();


        foreach ($rows as $row)
        {
            if (trim($row[0]) != 'Name') {
                Question::create([
                    'name' => $row[0],
                    'round' => $row[1],
                    'order' => $row[2],
                    'option1' => $row[3],
                    'option2' => $row[4],
                    'option3' => $row[5],
                    'option4' => $row[6],
                    'survey_id' => $this->surveyId
                ]);
            }
        }
    }
}
