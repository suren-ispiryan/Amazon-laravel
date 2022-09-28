<?php

namespace App\Console\Commands;

use App\Jobs\SendNewProductsList;
use Illuminate\Console\Command;

class SendProductEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send created products in last 24 hours to mail';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new SendNewProductsList());
        $this->comment($this->description);
    }
}
