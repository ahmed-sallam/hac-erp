<?php

namespace App\Observers;

use App\Models\PurchaseInvoice;
use App\Models\StockMovement;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PurchaseInvoiceObserver implements ShouldHandleEventsAfterCommit
{
    //
    public function create(PurchaseInvoice $purchaseInvoice)
    {

        $items = $purchaseInvoice->purchaseInvoiceLines();
        if($items){
            foreach ($items as $item){

        StockMovement::create([

        ]);
            }
        }
    }
}
