<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellReturnInvoiceLine extends Model
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
        'discount',
        'vat',
        'item_id',
        'sell_return_invoice_id',
        'store_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'item_id' => 'integer',
        'sell_return_invoice_id' => 'integer',
        'store_id' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Items::class);
    }

    public function sellReturnInvoice(): BelongsTo
    {
        return $this->belongsTo(SellReturnInvoice::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Stores::class);
    }
}
