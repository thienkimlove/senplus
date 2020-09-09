<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionImport implements ToCollection
{
    public $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection(Collection $rows)
    {

        Question::where('company_id', $this->companyId)->delete();

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
                    'company_id' => $this->companyId
                ]);
            }
        }
    }
}
