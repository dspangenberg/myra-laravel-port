<?php

namespace App\Console\Commands;

use App\Services\ReceiptBookkeepingService;
use App\Services\TransactionsBookkeepingService;
use Illuminate\Console\Command;

class CreateBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ReceiptBookkeepingService::runAll();
        TransactionsBookkeepingService::runAll();
    }
}