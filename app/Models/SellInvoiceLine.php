<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellInvoiceLine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'quantity',
        'price',
        'vat',
        'discount',
        'item_id',
        'sell_invoice_id',
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
        'discount' => 'decimal:2',
        'item_id' => 'integer',
        'store_id' => 'integer',
        'sell_invoice_id' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Items::class);
    }

    public function sellInvoice(): BelongsTo
    {
        return $this->belongsTo(SellInvoice::class);
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Stores::class);
    }
}
