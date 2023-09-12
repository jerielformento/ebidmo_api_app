<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WinnerAcknowledgement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $email;
    private $acknowledgement_link;
    private $item_name;
    private $store_name;
    private $price;

    public function __construct($email, $acknowledgement_link, $item, $store, $price)
    {
        $this->email = $email;
        $this->acknowledgement_link = $acknowledgement_link;
        $this->item_name = $item;
        $this->store_name = $store;
        $this->price = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = config('app.frontend_url').'/me/profile/transactions/checkout/'.$this->acknowledgement_link;

        return $this
            ->from('noreply@ebidmo.net')
            ->to($this->email)
            ->subject('eBidMo - Winner Acknowledgement')
            ->markdown('emails.winner_acknowledgement', [
                'url' => $url,
                'item' => $this->item_name,
                'store' => $this->store_name,
                'bid' => $this->price
            ]);
    }
}
