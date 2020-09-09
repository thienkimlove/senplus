<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class QuestionExport implements FromView
{
    public function view(): View
    {
        return view('exports.question');
    }
}
