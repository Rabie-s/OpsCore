<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\WarehousesReportExport;
use App\Exports\WarehouseTransactionExport;
use App\Exports\DevicesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function warehouseStockReport()
    {
        $currentDateTime = now()->format('Y-m-d H:i');
        return Excel::download(new WarehousesReportExport(), 'warehouse-stock-' . $currentDateTime . '.xlsx');
    }

    public function warehouseTransactionReport()
    {
        $currentDateTime = now()->format('Y-m-d H:i');
        return Excel::download(new WarehouseTransactionExport(), 'warehouse-transaction-report' . $currentDateTime . '.xlsx');
    }

    public function devicesReport()
    {
        return Excel::download(new DevicesExport, 'Devices.xlsx');
    }
}
