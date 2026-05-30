<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

class Admin extends Authenticatable implements FilamentUser
{
    use Notifiable;
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
