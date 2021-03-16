<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MakeOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $productId;

    /**
     * Create a new message instance.
     *
     * @param $productId
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.make_order', ['url' => url('products/' . $this->productId)]);
    }
}
