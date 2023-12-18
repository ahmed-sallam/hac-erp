<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseQuotationLine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'price',
        'vat',
        'item_id',
        'purchase_quotation_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal:2',
        'vat' => 'decimal:2',
        'item_id' => 'integer',
        'purchase_quotation_id' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Items::class);
    }

    public function purchaseQuotation(): BelongsTo
    {
        return $this->belongsTo(PurchaseQuotation::class);
    }
}
