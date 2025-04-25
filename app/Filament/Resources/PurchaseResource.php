<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Split;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;


class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square-stack';
    protected static ?string $navigationGroup = 'Transaction';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Purchase Information')
                    ->columns(3)
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label('Invoice No.')
                            ->placeholder('No.')
                            ->unique(ignoreRecord: true),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->placeholder('Select Supplier')
                            ->relationship('supplier', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Supplier Name')
                                    ->placeholder('Full Name')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->placeholder('example@gmail.com')
                                    ->email()
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('Phone Number')
                                    ->required(),
                            ]) 
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('purchase_date')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('M/ d/ Y')
                            ->placeholder('MM/DD/YYYY'),
                    ]) ->disabled(fn (?Purchase $record) => $record && $record->status === 'delivered'),

                Section::make('Product Detail')
                    ->schema([
                        Repeater::make('products')
                            ->relationship('product')
                            ->columns(4)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->placeholder('Select Product')
                                    ->relationship('product', 'model')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->brand} - {$record->model}")
                                    ->searchable()
                                    ->native(false)
                                    ->preload()
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->reactive(),
                                TextInput::make('serial_number')
                                    ->label('Serial Number')
                                    ->placeholder('SN')
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                                TextInput::make('price')
                                    ->numeric()
                                    ->reactive()
                                    ->prefix('$'),
                            ])
                            ->cloneable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $totalQty = collect($state)->sum(fn ($item) => (int) ($item['quantity'] ?? 0)); 
                                $totalCost = collect($state)->sum(fn ($item) => (int) ($item['quantity'] ?? 0) * (float) ($item['price'] ?? 0)); 
                                $set('total_qty', $totalQty);
                                $set('total_cost', $totalCost);
                            }),
                    ]) ->disabled(fn (?Purchase $record) => $record && $record->status === 'delivered'),

                    Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('total_qty')
                            ->label('Total Quantity')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('total_cost')
                            ->label('Total Cost')
                            ->numeric()
                            ->prefix('$')
                            ->disabled()
                            ->dehydrated(),
                    ]),
                    Split::make([
                        Section::make()
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->native(false)
                                ->required()
                                ->options([
                                    'pending' => 'Pending',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->default('pending')
                                ->reactive()
                                ->disabled(fn (?Purchase $record) => $record && $record->status === 'delivered')                             
                        ])
                    ]) 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->label('Invoice No.'),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->label('Supplier'),
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
                        'cancelled' => 'heroicon-m-x-circle',
                        'delivered' => 'heroicon-m-check-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('view_invoice')
                        ->icon('heroicon-o-document-text')
                        ->color('warning')
                        ->url(fn($record) => self::getUrl('invoice', ['record'=>$record->id])),
                    ])->tooltip('Actions'),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
            'invoice' => Pages\Invoice::route('/{record}/invoice'),
        ];
    }

}
