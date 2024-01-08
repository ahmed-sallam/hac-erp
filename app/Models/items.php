<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Items extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_number',
        'description_ar',
        'description_en',
        'req_min',
        'req_max',
        'is_set',
        'is_original',
        'item_image',
        'unit_image',
        'main_brand_id',
        'sub_brand_id',
        'category_id',
        'country_id',
//        'store_id',
//        'store_location_id',
        'is_active',
        'sale_price',
        'cost_price'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'req_min' => 'integer',
        'req_max' => 'integer',
        'is_set' => 'boolean',
        'is_original' => 'boolean',
        'main_brand_id' => 'integer',
        'sub_brand_id' => 'integer',
        'category_id' => 'integer',
        'country_id' => 'integer',
//        'store_id' => 'integer',
//        'store_location_id' => 'integer',
        'is_active'=>'boolean',
        'sale_price'=>'decimal:2',
        'cost_price'=>'decimal:2',
    ];

    public function mainBrand(): BelongsTo
    {
        return $this->belongsTo(MainBrands::class);
    }

    public function subBrand(): BelongsTo
    {
        return $this->belongsTo(SubBrands::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Countries::class);
    }

//    public function store(): BelongsTo
//    {
//        return $this->belongsTo(Stores::class);
//    }

//    public function storeLocation(): BelongsTo
//    {
//        return $this->belongsTo(StoreLocations::class);
//    }
}
