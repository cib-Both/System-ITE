<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Loanlist extends BaseWidget
{
    protected static ?string $heading = 'Loan List';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()->where('status', '!=', 'returned'))
            ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->label('Full Name'),
            Tables\Columns\TextColumn::make('position')
                ->searchable()
                ->label('Position'),
            Tables\Columns\TextColumn::make('department.name')
                ->searchable()
                ->label('Department'),
            Tables\Columns\TextColumn::make('inventory.product.model')
                ->searchable()
                ->label('Product Model'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->label('Status')
                ->icon('heroicon-m-play')
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'warning',
                }),
            ]);
    }
}
