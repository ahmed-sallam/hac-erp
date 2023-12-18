<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseQuotation extends Model
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
        'material_request_id',
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
        'material_request_id' => 'integer',
        'partner_id' => 'integer',
    ];

    public function materialRequest(): BelongsTo
    {
        return $this->belongsTo(MaterialRequest::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partners::class);
    }

    public function quotationLines(): HasMany
    {
        return $this->hasMany(PurchaseQuotationLine::class);
    }
}
