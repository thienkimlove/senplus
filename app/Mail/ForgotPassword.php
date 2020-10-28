<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;


    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $customer = $this->customer;
        return $this->from('support@mg.casonline.vn', 'CAS Team')
            ->subject('Quên mật khẩu tại CASONLINE')
            ->view('emails.forgot_pass', compact('customer'));
    }
}
