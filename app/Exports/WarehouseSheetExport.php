<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Product;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
class WarehouseSheetExport implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    protected Warehouse $warehouse;

    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    public function title(): string
    {
        return $this->warehouse->name;
    }

    public function headings(): array
    {
        return [
            'Product',
            'Quantity',
        ];
    }

    public function collection()
    {
        return Product::query()->whereHas('stockMovements', function ($query) {
            $query->where('warehouse_id', $this->warehouse->id);
        })->get()->map(function ($item) {
            return [
                'Product name' => $item->name,
                'Stock' => $item->getStockInWarehouse($this->warehouse->id),
            ];
        });
    }
}