<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Product;

class StockMovementService
{
    public function stockMovement($data)
    {
        $this->validateStockAvailability($data);
        dd($data);
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
