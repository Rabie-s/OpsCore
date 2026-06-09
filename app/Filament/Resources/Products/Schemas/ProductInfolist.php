<?php
namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Image')
                    ->schema([
                        ImageEntry::make('image')
                            ->disk('public')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Main Info')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('productType.name'),
                        TextEntry::make('stockUnit.name'),
                        IconEntry::make('is_active')
                            ->boolean(),
                        TextEntry::make('note')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Stock by Warehouse')
                    ->schema([
                        RepeatableEntry::make('warehouseStock')
                            ->label('')
                            ->schema([
                                TextEntry::make('warehouse_name')->label('Warehouse'),
                                TextEntry::make('stock')
                                    ->label('Current Stock')
                                    ->badge()
                                    ->color(fn($state) => $state > 0 ? 'success' : 'danger'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}