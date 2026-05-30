<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'location', 'qr_token'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'stock_movements')
            ->distinct();
    }
}
