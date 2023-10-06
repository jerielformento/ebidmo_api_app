<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $email;
    private $verification_link;

    public function __construct($email, $verification_link)
    {
        $this->email = $email; 
        $this->verification_link = $verification_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = config('app.url').'/api/account-verification/'.$this->verification_link;

        return $this
            ->from(config('mail.from.address'))
            ->to($this->email)
            ->subject(config('app.name').' - Account Verification')
            ->markdown('emails.account_verification', [
                'url' => $url
            ]);
    }
}
