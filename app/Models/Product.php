<?php

namespace App\Models;

use App\Enums\StockMovementType;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'image',
        'note',
        'is_active',
        'warehouse_id',
        'product_type_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getCurrentStockAttribute()
    {
        $in = $this->stockMovements()
            ->where('type', StockMovementType::In)
            ->sum('quantity');

        $init = $this->stockMovements()
            ->where('type', StockMovementType::Init)
            ->sum('quantity');

        $out = $this->stockMovements()
            ->where('type', StockMovementType::Out)
            ->sum('quantity');

        return $in + $init - $out;
    }
}
