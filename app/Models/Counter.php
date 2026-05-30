<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = ['counter_number', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
