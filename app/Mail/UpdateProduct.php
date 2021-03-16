<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateProduct extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $productId;

    /**
     * Create a new message instance.
     *
     * @param User $user
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
        return $this->markdown('emails.update_product', ['url' => url('products/' . $this->productId . '/edit')]);
    }
}
