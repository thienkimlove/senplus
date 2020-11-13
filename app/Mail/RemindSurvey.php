<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Survey;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class RemindSurvey extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $survey;


    public function __construct(Customer $customer, Survey $survey)
    {
        $this->customer = $customer;
        $this->survey = $survey;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $customer = $this->customer;
        $survey = $this->survey;
        return $this->from('support@mg.casonline.vn', 'CAS Team')
            ->subject('Nhắc nhở hoàn thành khảo sát - '.$survey->name)
            ->view('emails.remind_survey', compact('customer', 'survey'));
    }
}
