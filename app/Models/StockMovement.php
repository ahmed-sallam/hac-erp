<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockMovement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movement_type',
        'source_store_id',
        'destination_store_id',
        'employee_id',
        'movement_date',
        'reference',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'source_store_id' => 'integer',
        'destination_store_id' => 'integer',
        'employee_id' => 'integer',
        'movement_date' => 'date',
    ];

    public function sourceStore(): BelongsTo
    {
        return $this->belongsTo(Stores::class);
    }

    public function destinationStore(): BelongsTo
    {
        return $this->belongsTo(Stores::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }

    public function movementLines():HasMany
    {
        return $this->hasMany(StockMovementLine::class);
    }
}
