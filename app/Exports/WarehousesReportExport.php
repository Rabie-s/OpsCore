<?php

namespace App\Exports;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WarehousesReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $warehouses = Warehouse::all();

        foreach ($warehouses as $warehouse) {
            $sheets[] = new WarehouseSheetExport($warehouse);
        }

        return $sheets;
    }
}