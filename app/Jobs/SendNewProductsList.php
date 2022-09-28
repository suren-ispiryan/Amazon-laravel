<?php

namespace App\Jobs;

use App\Mail\User\SendNewProducts;
use App\Mail\User\VerifyMail;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewProductsList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    protected $products;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::whereNotNull('email_verified_at')->get()->each(function ($user) {
            Mail::to($user->email)->queue(new SendNewProducts());
        });
    }
}
