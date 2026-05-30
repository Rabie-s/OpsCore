<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StockMovementType;

class StockMovement extends Model
{
    protected $fillable = [
        'type',
        'quantity',
        'note',
        'product_id',
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
}
