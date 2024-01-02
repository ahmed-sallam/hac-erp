<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastItem = SellQuotation::latest()->first();
            if ($lastItem) {
                $item_number = (int)$lastItem->quotation_number;
                $item_number = $item_number + 1;
                $model->quotation_number = $item_number . '';
            } else {

                $currentYear = date('Y');

                $model->quotation_number = $currentYear . '0001';
            }
        });

    }

public function quotationLines():HasMany
{
    return $this->hasMany(SellQuotationLine::class);
}

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partners::class);
    }



}
