<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];
    
    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
