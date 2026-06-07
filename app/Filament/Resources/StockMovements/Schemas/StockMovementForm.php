<?php

namespace App\Filament\Resources\StockMovements\Schemas;

use App\Enums\StockMovementType;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Warehouse;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StockMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Stock Movement')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('type')
                            ->options(StockMovementType::class)
                            ->required()
                            ->columnSpanFull(),
                        Select::make('product_id')
                            ->label('Product')
                            ->options(
                                Product::query()
                                    ->get()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric(),
                                Select::make('warehouse_id')
                                    ->label('Warehouse')
                                    ->options(
                                        Warehouse::query()
                                            ->get()
                                            ->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->required(),
                            ]),
                        Textarea::make('note')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
