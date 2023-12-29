<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'delivery_date',
        'invoice_type',
        'partner_id',
        'sell_quotation_id',
        'discount',
        'sub_total',
        'vat',
        'total',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'invoice_date' => 'date',
        'delivery_date' => 'date',
        'partner_id' => 'integer',
        'sell_quotation_id' => 'integer',
        'discount' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'vat' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partners::class);
    }

    public function sellQuotation(): BelongsTo
    {
        return $this->belongsTo(SellQuotation::class);
    }
}
