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
                Purchase::query()->where('status', '=', 'pending'))
            ->columns([
                Tables\Columns\TextColumn::make('voucher_ref')
                    ->searchable()
                    ->label('Voucher Ref.'),
                Tables\Columns\TextColumn::make('total_qty')
                    ->sortable()
                    ->label('Total Quantity'),
                Tables\Columns\TextColumn::make('total_cost')
                    ->sortable()
                    ->label('Total Cost')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->label('Purchase Date'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->icon(fn (string $state): ?string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                    }),
                ]);
            // ->actions([
            //     Tables\Actions\Action::make('view_invoice')
            //     ->icon('heroicon-o-document-text')
            //     ->color('warning')
            //     ->url(fn ($record) => PurchaseResource::getUrl('invoice', ['record' => $record->id]))
            // ]);
    }
}
