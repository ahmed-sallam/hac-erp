<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialRequest extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
//    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'request_date',
        'status',
        'store_id',
        'employee_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'request_date' => 'date',
        'store_id' => 'integer',
        'employee_id' => 'integer',
    ];
    protected $attributes = [
        'status'=>'pending',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $lastItem = MaterialRequest::latest()->first();
            if ($lastItem) {
                $item_number = (int)$lastItem->order_number;
                $item_number = $item_number + 1;
                $model->order_number = $item_number . '';
            } else {

                $currentYear = date('Y');

                $model->order_number = $currentYear . '0001';
            }
        });

    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Stores::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }

    public function requestLines(): HasMany
    {
        return $this->hasMany(MaterialRequestLine::class);
    }

    /**
     * @param $model
     * @return void
     */

}
