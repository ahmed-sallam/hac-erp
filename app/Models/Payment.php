<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'date',
        'label',
        'payment_method',
        'purchase_invoice_id',
        'partner_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'amount' => 'decimal:2',
        'date' => 'date',
        'purchase_invoice_id' => 'integer',
        'partner_id' => 'integer',
    ];

    public function purchaseInvoice(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }
}
