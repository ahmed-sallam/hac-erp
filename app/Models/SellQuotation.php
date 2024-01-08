<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellQuotation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quotation_number',
        'quotation_date',
        'status',
        'partner_id',
        'employee_id',
        'customer_request_id',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'quotation_date' => 'date',
        'partner_id' => 'integer',
        'employee_id' => 'integer',
        'customer_request_id' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastItem = SellQuotation::latest()->first();
            $prefix = 'SQ';
            if ($lastItem) {
                $item_string = substr($lastItem->quotation_number, 2);
                $item_number = (int)$item_string;
                $item_number = $item_number + 1;
                $model->quotation_number = $prefix . $item_number;
            } else {
                $currentYear = date('Y');
                $model->quotation_number = $prefix . $currentYear . '0001';
            }
        });
    }

    public function quotationLines(): HasMany
    {
        return $this->hasMany(SellQuotationLine::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partners::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }
    public function customerRequest(): BelongsTo
    {
        return $this->belongsTo(CustomerRequest::class);
    }
}
