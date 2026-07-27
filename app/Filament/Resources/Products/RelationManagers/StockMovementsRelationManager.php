<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Enums\StockMovementType;
use App\Services\StockMovementService;
use App\Models\Warehouse;
use Filament\Notifications\Notification;
use App\Models\StockMovement;


class StockMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'stockMovements';

    //protected static ?string $relatedResource = ProductResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('warehouse_id')
                    ->label('Warehouse')
                    ->options(fn() => Warehouse::pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive(),

                Select::make('type')
                    ->label('Movement Type')
                    ->options(StockMovementType::class)
                    ->default(StockMovementType::In)
                    ->required()
                    ->reactive(),

                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),

                Textarea::make('note')
                    ->label('Note')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

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
                CreateAction::make()
                ->model(StockMovement::class)
                    ->using(function ($data, RelationManager $livewire,CreateAction $action) {
                        try {
                            $data['product_id'] = $livewire->getOwnerRecord()->id;
                            $data['admin_id'] = auth()->guard('admin')->id();
                            return app(StockMovementService::class)->addStockMovement($data);
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Insufficient Stock')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            $action->halt();
                        }
                    }),
            ]);
    }
}
