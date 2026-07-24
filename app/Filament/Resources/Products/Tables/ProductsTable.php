<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Warehouse;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('stock')
                    ->state(fn($record) => $record->getStock()),
                TextColumn::make('productType.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stockUnit.name')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('image')
                    ->disk('public'),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_type')
                    ->relationship('productType', 'name')
                    ->label('Product Type'),
                SelectFilter::make('warehouse')
                    ->query(fn($query) => $query->whereHas('warehouses'))
                    ->options(Warehouse::pluck('name', 'id'))
                    ->label('Warehouse'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                Action::make('warehouseReport')
                    ->label('تقرير المخازن')
                    ->url(fn() => route('warehouseStockReport')),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
