<?php

namespace App\Observers;

use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderObserver
{
    /**
     * Handle the OrderModel "created" event.
     */
    public function created(OrderModel $orderModel): void
    {
        //
    }

    /**
     * Handle the OrderModel "updated" event.
     */
    public function updating(OrderModel $order)
{
    if (
        $order->isDirty('is_payment') &&
        $order->is_payment == 1 &&
        !$order->stock_deducted
    ) {
        foreach ($order->items as $item) {
            $product = ProductModel::find($item->product_id);
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }
        }
        $order->stock_deducted = true;
    }
}


    /**
     * Handle the OrderModel "deleted" event.
     */
    public function deleted(OrderModel $orderModel): void
    {
        //
    }

    /**
     * Handle the OrderModel "restored" event.
     */
    public function restored(OrderModel $orderModel): void
    {
        //
    }

    /**
     * Handle the OrderModel "force deleted" event.
     */
    public function forceDeleted(OrderModel $orderModel): void
    {
        //
    }
}