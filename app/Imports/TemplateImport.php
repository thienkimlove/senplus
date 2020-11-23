<?php

namespace App\Imports;

use App\Helpers;
use App\Models\Template;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TemplateImport implements ToCollection
{
    public $templateId;

    public function __construct($templateId)
    {
        $this->templateId = $templateId;
    }

    public function collection(Collection $rows)
    {
        $questions = [];
        $mapTemplate = Helpers::mapTemplateQuestion();
        foreach ($rows as $index => $row) {
            if ($index != 0) {

                $tempQuestion = [];

                foreach ($row as $key => $value) {
                    $tempQuestion[$mapTemplate[$key]['name']] = $value;
                }
                $questions[] = $tempQuestion;
            }
        }

        if ($questions) {
           try {
               Template::find($this->templateId)->update([
                   'questions' => json_encode($questions)
               ]);
           } catch (\Exception $exception) {

           }
        }
    }
}
