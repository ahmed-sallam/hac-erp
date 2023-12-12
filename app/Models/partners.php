<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partners extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'partner_type',
        'mobile',
        'email',
        'payment_type',
        'credit_limit',
        'credit_period',
        'country_id',
        'employee_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'credit_limit' => 'integer',
        'credit_period' => 'integer',
        'country_id' => 'integer',
        'employee_id' => 'integer',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Countries::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }
}
