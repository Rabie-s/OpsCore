<?php

namespace App\Filament\Resources\StockMovements\Pages;

use App\Enums\StockMovementType;
use App\Filament\Resources\StockMovements\StockMovementResource;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\StockMovementService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BulkStockMovement extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = StockMovementResource::class;
    public ?array $data = [];

    protected string $view = 'filament.resources.stock-movements.pages.bulk-stock-movement';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('Type')
                            ->options(StockMovementType::class)
                            ->required()
                            ->live(),
                        Select::make('warehouse_id')
                            ->label('Wharehouse')
                            ->options(Warehouse::select('id', 'name')->pluck('name', 'id'))
                            ->required()
                            ->live(),

                        Repeater::make('products')
                            ->label('Products')
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->options(function (Get $get) {
                                        $warehouseId = $get('../../warehouse_id');
                                        $movementType = $get('../../Type');

                                        // For stock OUT, only show products in this warehouse
                                        if ($movementType === StockMovementType::Out) {
                                            return Product::select('id', 'name')
                                            ->where('is_active', true)
                                                ->whereHas(
                                                    'stockMovements',
                                                    fn(Builder $q) =>
                                                    $q->where('warehouse_id', $warehouseId)
                                                )
                                                ->get()
                                                ->mapWithKeys(fn ($product) => [$product->id => "ID: {$product->id} - {$product->name}"]);
                                        }
                                        // For IN/INIT, show all active products
                                        return Product::select('id', 'name')
                                        ->where('is_active', true)
                                        ->get()
                                        ->mapWithKeys(fn ($product) => [$product->id => "ID: {$product->id} - {$product->name}"]);
                                    })
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric()
                            ])->columns(2)
                            ->minItems(1)
                            ->columnSpanFull()


                    ])

            ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        try {
            DB::transaction(function () use ($data) {
                $service = new StockMovementService();

                foreach ($data['products'] as $product) {
                    $service->addStockMovement([
                        'product_id' => $product['product_id'],
                        'warehouse_id' => $data['warehouse_id'],
                        'type' => $data['Type'],
                        'admin_id'=>auth()->guard('admin')->id(),
                        'quantity' => $product['quantity'],
                    ]);
                }
            });

            Notification::make()
                ->success()
                ->title('Stock movements created successfully')
                ->send();

            $this->form->fill();

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error creating stock movements')
                ->body($e->getMessage())
                ->send();
        }
    }


}