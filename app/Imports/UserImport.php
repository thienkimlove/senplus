<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Filter;
use App\Models\Question;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    public $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection(Collection $rows)
    {

       $headers = [];

        foreach ($rows as $row) {
            if (trim($row[0]) == 'Name') {
                foreach ($row as $index => $value) {

                    if (strpos($value, 'Thuộc Tính') !== false) {
                        $filterName = trim(str_replace('Thuộc Tính ', '', $value));

                        $filter = Filter::where('name', $filterName)->first();

                        if ($filter) {
                            $headers[$index] = $filter->id;
                        }
                    }


                }
            }
        }


        foreach ($rows as $row) {
            if (trim($row[0]) != 'Name') {
                $user = null;
                try {
                   $user = User::create([
                        'name' => $row[0],
                        'email' => $row[1],
                        'password' => Hash::make($row[2]),
                        'company_id' => $this->companyId
                    ]);
                } catch (\Exception $exception) {
                    //pass
                }

                if ($user) {
                   $jsonAttrs = [];
                   foreach ($row as $index => $value) {
                       if (isset($headers[$index])) {
                           $jsonAttrs[] = [
                               'att_id' => $headers[$index],
                               'att_value' => $value
                           ];
                       }
                   }
                   if ($jsonAttrs) {
                       $user->update([
                           'filters' => json_encode($jsonAttrs, true)
                       ]);
                   }
                }

            }
        }
    }
}
