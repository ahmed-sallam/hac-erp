<?php

namespace App\Observers;

use App\Models\MaterialRequest;
use App\Models\PurchaseQuotation;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PurchaseQuotationObserver implements ShouldHandleEventsAfterCommit
{
    public function created(PurchaseQuotation $purchaseQuotation)
    {
        $materialRequest = MaterialRequest::find($purchaseQuotation->material_request_id);
        if ($materialRequest) {
            $materialRequest->status = 'quotation';
            $materialRequest->save();
        }
    }

    public function updated(PurchaseQuotation $purchaseQuotation)
    {
        $materialRequest = MaterialRequest::find($purchaseQuotation->material_request_id);
        if ($materialRequest) {
            if ($purchaseQuotation->status == '') {
                // todo check if reject , or completed what should i do
//            $materialRequest->status = 'pricing';
//            $materialRequest->save();
            }
        }
    }
}
