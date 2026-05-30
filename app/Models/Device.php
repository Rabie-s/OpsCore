<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['ip', 'device_number', 'counter_id', 'device_type'];

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'device_type');
    }
}
