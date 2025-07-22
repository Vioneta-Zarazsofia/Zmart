<?php

namespace App\Console\Commands;
use App\Models\OrderModel;

use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-orders';

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
    $orders = OrderModel::where('is_payment', 0)
        ->where('payment_deadline', '<', now())
        ->where('status', 'pending')
        ->get();

    foreach ($orders as $order) {
        $order->status = 'cancelled';
        $order->save();
    }

    $this->info(count($orders) . ' order dibatalkan.');
}

}