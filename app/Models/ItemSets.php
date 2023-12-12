<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemSets extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'set_item_id',
        'member_item_id',
        'quantity',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'set_item_id' => 'integer',
        'member_item_id' => 'integer',
        'quantity' => 'integer',
    ];

    public function setItem(): BelongsTo
    {
        return $this->belongsTo(Items::class);
    }

    public function memberItem(): BelongsTo
    {
        return $this->belongsTo(Items::class);
    }
}
