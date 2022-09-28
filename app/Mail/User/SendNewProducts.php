<?php

namespace App\Mail\User;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewProducts extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->product = Product::where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.productList');
    }
}
