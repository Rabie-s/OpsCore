<?php

namespace App\Filament\Resources\Products\RelationManagers;


use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StockMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'stockMovements';

    //protected static ?string $relatedResource = ProductResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse.name')
                    ->label('Warehouse'),

                TextColumn::make('type')
                    ->badge(),

                TextColumn::make('quantity')
                    ->label('Quantity'),

                TextColumn::make('note')
                    ->label('Note')
                    ->limit(40),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
