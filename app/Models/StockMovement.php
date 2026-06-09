<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StockMovementType;

class StockMovement extends Model
{

    protected static function booted(): void
    {
        static::creating(function (StockMovement $movement) {
            $movement->admin_id = auth()->guard('admin')->id();
        });
    }

    protected $fillable = [
        'type',
        'quantity',
        'note',
        'product_id',
        'warehouse_id',
        'admin_id',
    ];

    protected $casts = [
        'type' => StockMovementType::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
