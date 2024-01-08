<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'date',
        'partner_id',
        'employee_id',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'partner_id' => 'integer',
        'employee_id' => 'integer',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partners::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }
    public function requestLines(): HasMany
    {
        return $this->hasMany(CustomerRequestLine::class);
    }
    public static function boot(): void
    {
        // todo: handle new year
        parent::boot();
        static::creating(function ($model) {
            $lastItem = CustomerRequest::latest()->first();
            $prefix = 'CR';
            if ($lastItem) {
                $item_string = substr($lastItem->number, 2);
                $item_number = (int)$item_string;
                $item_number = $item_number + 1;
                $model->number = $prefix . $item_number;
            } else {
                $currentYear = date('Y');
                $model->number = $prefix . $currentYear . '0001';
            }
        });
    }
}
