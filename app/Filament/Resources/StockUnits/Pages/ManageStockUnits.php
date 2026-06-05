<?php

namespace App\Filament\Resources\StockUnits\Pages;

use App\Filament\Resources\StockUnits\StockUnitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStockUnits extends ManageRecords
{
    protected static string $resource = StockUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
