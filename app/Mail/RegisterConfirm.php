<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class RegisterConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public $isAdminCreate;


    public function __construct(Customer $customer, $isAdminCreate)
    {
        $this->customer = $customer;
        $this->isAdminCreate = $isAdminCreate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $customer = $this->customer;

        if ($this->isAdminCreate) {
            return $this->from('support@mg.casonline.vn', 'CAS Team')
                ->subject('Kích hoạt tài khoản tại CASONLINE')
                ->view('emails.register_confirm_with_pass', compact('customer'));
        } else {
            return $this->from('support@mg.casonline.vn', 'CAS Team')
                ->subject('Kích hoạt tài khoản tại CASONLINE')
                ->view('emails.register_confirm', compact('customer'));
        }


    }
}
