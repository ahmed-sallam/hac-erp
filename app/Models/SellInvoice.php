<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'employee_id',
        'customer_request_id',
        'sell_quotation_id',
        'stock_movement_id',
        'sub_total',
        'discount',
        'total',
        'vat',
        'net_total',
        'notes'
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
        'employee_id' => 'integer',
        'customer_request_id' => 'integer',
        'sell_quotation_id' => 'integer',
        'stock_movement_id' => 'integer',
        'discount' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'vat' => 'decimal:2',
        'total' => 'decimal:2',
        'net_total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastItem = SellInvoice::latest()->first();
            $prefix = 'SI';
            if ($lastItem) {
                $item_string = substr($lastItem->invoice_number, 2);
                $item_number = (int)$item_string;
                $item_number = $item_number + 1;
                $model->invoice_number = $prefix . $item_number;
            } else {
                $currentYear = date('Y');
                $model->invoice_number = $prefix . $currentYear . '0001';
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

    public function stockMovement(): BelongsTo
    {
        return $this->belongsTo(StockMovement::class);
    }
    public function customerRequest(): BelongsTo
    {
        return $this->belongsTo(CustomerRequest::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }
}
