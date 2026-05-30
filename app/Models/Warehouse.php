<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'location', 'qr_token'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
