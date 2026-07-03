<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\StockMovementService;
use App\Enums\StockMovementType;
use App\Http\Requests\WithdrawStockRequest;


class WarehouseController extends Controller
{
    public function show($id)
    {
        $warehouse = Warehouse::select('id', 'name')->where('id', $id)->first();
        $products = Product::whereHas('warehouses', function ($query) use ($id) {
            $query->where('warehouses.id', $id);
        })
            ->with(['productType:id,name', 'stockUnit:id,symbol'])
            ->get();

        $products->each(function ($product) use ($id) {
            $product->stock_in_warehouse = $product->getStockInWarehouse($id);
        });

        return Inertia::render('Admin/Warehouse/Index', [
            'warehouse_id' => $id,
            'warehouse' => $warehouse,
            'products' => $products,
        ]);
    }

    public function withdraw(WithdrawStockRequest $request)
    {

        $data = [
            'product_id' => $request->input('productId'),
            'warehouse_id' => $request->input('wareHouseId'),
            'type' => StockMovementType::Out,
            'quantity' => $request->input('quantity'),
            'admin_id' => auth()->guard('admin')->id(),
            'note' => $request->input('note') ?? null,
        ];

        try {
            $stockMovement = new StockMovementService();
            $stockMovement->addStockMovement($data);
            return Inertia::flash('message', 'تمت العمليه بنجاح')->back();
        } catch (\Exception $e) {
            return Inertia::flash('message', $e->getMessage())->back();
        }


    }
}
