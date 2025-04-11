<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PurchaseResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Purchase;

class Purchaselist extends BaseWidget
{
    protected static ?string $heading = 'Purchase Pending List';
    protected static ?int $sort = 1;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Purchase::query()->where('status', '!=', 'delivered'))
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->label('Invoice'),
                Tables\Columns\TextColumn::make('total_qty')
                    ->sortable()
                    ->label('Total Quantity'),
                Tables\Columns\TextColumn::make('total_cost')
                    ->sortable()
                    ->label('Total Cost')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_invoice')
                ->icon('heroicon-o-document-text')
                ->color('warning')
                ->url(fn ($record) => PurchaseResource::getUrl('invoice', ['record' => $record->id]))
            ]);
    }
}
