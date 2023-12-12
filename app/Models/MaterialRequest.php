<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialRequest extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
}