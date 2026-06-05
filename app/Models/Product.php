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
        'product_type_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockUnit()
    {
        return $this->belongsTo(StockUnit::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'stock_movements')
            ->distinct();
    }

    public function getStockInWarehouse(int $warehouseId)
    {
        $in = $this->stockMovements()
            ->where('warehouse_id', $warehouseId)
            ->where('type', StockMovementType::In)
            ->sum('quantity');

        $init = $this->stockMovements()
            ->where('warehouse_id', $warehouseId)
            ->where('type', StockMovementType::Init)
            ->sum('quantity');

        $out = $this->stockMovements()
            ->where('warehouse_id', $warehouseId)
            ->where('type', StockMovementType::Out)
            ->sum('quantity');

        return $in + $init - $out;
    }
}
