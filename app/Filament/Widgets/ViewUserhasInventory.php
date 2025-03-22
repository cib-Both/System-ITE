<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ViewUserhasInventory extends BaseWidget
{
    protected static ?string $heading = 'User has Inventory';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventory::query()
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Inventory Name')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->sortable(),
            ]);
    }
}
