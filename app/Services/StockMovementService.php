<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\StockMovement;

class StockMovementService
{
    public function addStockMovement($data): void
    {
        $this->validateStockAvailability($data);
        StockMovement::create([
            'product_id' => $data['product_id'],
            'warehouse_id' => $data['warehouse_id'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'note' => $data['note'] ?? null,
        ]);
    }

    private function validateStockAvailability(array $data): void
    {
        if ($data['type'] !== StockMovementType::Out) {
            return;
        }

        $product = Product::find($data['product_id']);

        $stock = $product->getStockInWarehouse($data['warehouse_id']);
        //dd($stock);

        if ($data['quantity'] > $stock) {
            throw new \Exception("Only {$stock} unit(s) available.");
        }
    }
}
