<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class RegisterFacebook extends Mailable
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
            ->subject('Bã đã đăng ký tài khoản tại CASONLINE')
            ->view('emails.register_facebook', compact('customer'));
    }
}
