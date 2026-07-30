<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WarehouseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('location'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('qr_code')
                    ->state(fn($record) => 'qr')
                    ->formatStateUsing(function ($record) {
                        return \LaraZeus\Qr\Facades\Qr::render(
                            data: url("warehouse/{$record->id}"),
                            options: \LaraZeus\Qr\Facades\Qr::getDefaultOptions()
                        );
                    }),
            ]);
    }
}
