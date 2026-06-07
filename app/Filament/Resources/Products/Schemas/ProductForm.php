<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductType;
use App\Models\StockUnit;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                Select::make('product_type_id')
                                    ->label('product type')
                                    ->options(
                                        ProductType::query()
                                            ->get()
                                            ->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->required(),
                                Select::make('stock_unit_id')
                                    ->label('stock unit')
                                    ->options(
                                        StockUnit::query()
                                            ->get()
                                            ->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->required(),
                            ]),
                        FileUpload::make('image')
                            ->image(),
                        Textarea::make('note')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                        ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}
