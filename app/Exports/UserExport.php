<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class UserExport implements FromView
{
    public $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }


    public function view(): View
    {
        return view('exports.user', [
            'company' => Company::find($this->companyId)
        ]);
    }
}
