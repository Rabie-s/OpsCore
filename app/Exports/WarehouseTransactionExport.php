<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\StockMovement;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class WarehouseTransactionExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function title(): string
    {
        return 'Warehouses Report';
    }

    public function headings(): array
    {
        return [
            'Warehouse Name',
            'Transaction type',
            'Admin',
            'Product Name',
            'Quantity',
            'Date'
        ];
    }

    public function collection()
    {
        return StockMovement::select('type', 'quantity', 'created_at', 'warehouse_id', 'admin_id', 'product_id')
            ->with('admin:id,name', 'warehouse:id,name', 'product:id,name')->get()->map(function ($transaction) {
                return [
                    'Warehouse Name: ' => $transaction->warehouse->name,
                    'Transaction type: ' => $transaction->type->name,
                    'Admin: ' => $transaction->admin->name,
                    'Product Name: ' => $transaction->product->name,
                    'Quantity: ' => $transaction->quantity,
                    'Date: ' => $transaction->created_at->format('Y/m/d h:i A')
                ];
            });
    }
}
