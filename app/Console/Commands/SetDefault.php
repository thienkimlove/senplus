<?php

namespace App\Console\Commands;

use App\Helpers;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Survey;
use Illuminate\Console\Command;

class SetDefault extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set all customer not have company and survey not have company to default Company';

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
        //return 0;
        // check if have company default
        $company = Helpers::getDefaultCompany();

        $customerNotHaveCompany = Customer::whereNull('company_id')->get();

        if ($customerNotHaveCompany->count() > 0) {
            foreach ($customerNotHaveCompany as $customer) {
                $customer->update([
                    'company_id' => $company->id
                ]);
            }
        }

        $surveyNotHaveCompany = Survey::whereNull('company_id')->get();

        if ($surveyNotHaveCompany->count() > 0) {
            foreach ($surveyNotHaveCompany as $survey) {
                $survey->update([
                    'company_id' => $company->id
                ]);
            }
        }

        $this->line('Done');
    }
}
