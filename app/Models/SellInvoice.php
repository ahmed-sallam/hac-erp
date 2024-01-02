<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'reference'
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastItem = SellInvoice::latest()->first();
            if ($lastItem) {
                $item_number = (int)$lastItem->invoice_number;
                $item_number = $item_number + 1;
                $model->invoice_number = $item_number . '';
            } else {

                $currentYear = date('Y');

                $model->invoice_number = $currentYear . '0001';
            }
        });

    }



    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partners::class);
    }

    public function sellQuotation(): BelongsTo
    {
        return $this->belongsTo(SellQuotation::class);
    }

    public function invoiceLines(): HasMany
    {
        return $this->hasMany(SellInvoiceLine::class);
    }
}
