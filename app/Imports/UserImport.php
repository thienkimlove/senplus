<?php

namespace App\Imports;

use App\Helpers;
use App\Models\Customer;
use App\Models\Filter;
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
            if (trim($row[0]) == Helpers::mapCustomer()[0]['value']) {
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
            if (trim($row[0]) != Helpers::mapCustomer()[0]['value']) {
                $customer = null;
                try {

                    $values = [
                        'company_id' => $this->companyId
                    ];

                    foreach (Helpers::mapCustomer() as $index => $ars) {
                        $values[$ars['name']] = $row[$index];
                    }

                    $customer = Customer::create($values);
                } catch (\Exception $exception) {
                    //pass
                }

                if ($customer) {
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
                       $customer->update([
                           'options' => $jsonAttrs
                       ]);
                   }
                }

            }
        }
    }
}
