<?php

namespace App\Filament\Resources\StockMovements\Pages;

use App\Filament\Resources\StockMovements\StockMovementResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use App\Services\StockMovementService;
use Filament\Notifications\Notification;

class CreateStockMovement extends CreateRecord
{
    protected static string $resource = StockMovementResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $service = new StockMovementService();

            return $service->addStockMovement($data);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Insufficient Stock')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->halt();
        }
    }
}
