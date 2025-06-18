<?php

namespace App\Filament\Resources;

use App\Filament\Exports\InventoryExporter;
use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use Dom\Text;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Count;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?int $navigationSort = 1;

    public static function getGloballySearchableAttributes(): array
    {
    return [
        'class_of_asset',
        'asset_identity_no',
        'product.model',
        'serial_number',
    ];
    }
    public static function getGlobalSearchResultDetails($record): array
{
    return [
        'class_of_asset' => $record->class_of_asset,
        'asset_identity_no' => $record->asset_identity_no,
        'product.brand' => $record->product->brand,
        'product.model' => $record->product->model,
        'serial_number' => $record->serial_number,
    ];
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Asset Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('class_of_asset')
                            ->label('Class of Asset')
                            ->placeholder('Class of Asset')
                            ->required(),
                        TextInput::make('asset_identity_no')
                            ->label('Asset Identity No')
                            ->placeholder('Asset Identity No')
                            ->unique(ignoreRecord: true)
                            ->required(),
                    ]),
                Section::make('Inventory Information')
                    ->columns(3)
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->placeholder('Select Product')
                            ->relationship('product', 'model')
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required(),
                        TextInput::make('serial_number')
                            ->label('Serial Number')
                            ->placeholder('SN')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Code')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1),
                        TextInput::make('user')
                            ->label('User')
                            ->placeholder('User Full Name'),
                        Select::make('locate_id')
                            ->label('Select Location and Condition')
                            ->relationship('locate', 'location')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->location} - {$record->building}")
                            ->searchable()
                            ->native(false)
                            ->preload(),
                    ]),
                Split::make([
                    Section::make()
                        ->columns(1)
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->placeholder('Select Status')
                                ->native(false)
                                ->options([
                                    'available' => 'Available',
                                    'loaned' => 'Loaned',
                                    'damaged' => 'Damaged',
                                    'lost' => 'Lost',
                                ])
                                ->default('available')
                                ->required(),
                            Select::make('remark')
                                ->label('Remarks')
                                ->placeholder('Select Remarks')
                                ->native(false)
                                ->options([
                                    'install' => 'Install',
                                    'not yet install' => 'Not Yet Install',
                                ])
                                ->default('not yet install')
                                ->required(),
                        ]),                    
                    ]),             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('class_of_asset')
                    ->searchable()
                    ->label('Class of Asset'),
                Tables\Columns\TextColumn::make('asset_identity_no')
                    ->searchable()
                    ->label('Asset Identity No'),
                Tables\Columns\TextColumn::make('product.brand')
                    ->searchable()
                    ->label('Brand'),
                Tables\Columns\TextColumn::make('product.model')
                    ->searchable()
                    ->label('Model'),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->label('Serial Number'),
                Tables\Columns\TextColumn::make('purchase.purchase_date')
                    ->searchable()
                    ->label('Purchase date')
                    ->dateTime('d-M-Y'),
                Tables\Columns\TextColumn::make('purchase.voucher_ref')
                    ->searchable()
                    ->label('Voucher Ref.'),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable()
                    ->label('Quantity')
                    ->summarize(Count::make()),
                Tables\Columns\TextColumn::make('unit_price')
                    ->sortable()
                    ->label('Unit Price')
                    ->money('usd')
                    ->summarize(
                        Sum::make()
                            ->money('usd')),
                Tables\Columns\TextColumn::make('user')
                    ->searchable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('locate.location')
                    ->searchable()
                    ->label('Location'),
                Tables\Columns\TextColumn::make('locate.building')
                    ->searchable()
                    ->label('Building'),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Remarks')
                    ->icon(fn (string $state): ?string => match ($state) {
                        'install' => 'heroicon-m-check-circle',
                        'not yet install' => 'heroicon-m-minus-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'install' => 'success',
                        'not yet install' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state): ?string => match ($state) {
                        'available' => 'heroicon-m-check-circle',
                        'loaned' => 'heroicon-m-arrow-up-on-square-stack',
                        'damaged' => 'heroicon-m-exclamation-circle',
                        'lost' => 'heroicon-m-no-symbol',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'loaned' => 'warning',
                        'damaged' => 'danger',
                        'lost' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->label('Code'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'available' => 'Available',
                    'loaned' => 'Loaned',
                    'damaged' => 'Damaged',
                    'lost' => 'Lost',
                ]),
            Tables\Filters\SelectFilter::make('remark')
                ->label('Remarks')
                ->options([
                    'install' => 'Install',
                    'not yet install' => 'Not Yet Install',
                ]),
            Tables\Filters\SelectFilter::make('locate_id')
                ->label('Location')
                ->relationship('locate', 'location')
                ->searchable(),
            Tables\Filters\SelectFilter::make('building')
                ->label('Building')
                ->relationship('locate', 'building')
                ->searchable(),
            Tables\Filters\TrashedFilter::make()
                ->label('Deleted'),
            Tables\Filters\Filter::make('purchase_date')
                ->form([
                    DatePicker::make('from')
                        ->label('Purchase from')
                        ->native(false)
                        ->closeOnDateSelection()
                        ->displayFormat('d/ M/ Y')
                        ->placeholder('DD/MM/YYYY'),
                    DatePicker::make('to')
                        ->label('To')
                        ->native(false)
                        ->closeOnDateSelection()
                        ->displayFormat('d/ M/ Y')
                        ->placeholder('DD/MM/YYYY'),
                ])
                ->query(fn (Builder $query, array $data): Builder => $query
                ->when($data['from'], fn (Builder $query, $date) => $query->whereHas('purchase', fn (Builder $subQuery) => $subQuery->whereDate('purchase_date', '>=', $date)))
                ->when($data['to'], fn (Builder $query, $date) => $query->whereHas('purchase', fn (Builder $subQuery) => $subQuery->whereDate('purchase_date', '<=', $date)))
                )
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->tooltip('Actions'),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()
                    ->label('Export')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->iconPosition(IconPosition::After)
                    ->exporter(InventoryExporter::class)
                    ->color('success')
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Components\Section::make('Inventory Details')
                ->schema([
                    Components\Split::make([
                        Components\Grid::make(2)
                            ->schema([
                                Components\Group::make([
                                    Components\TextEntry::make('class_of_asset')
                                        ->label('Class of Asset'),
                                    Components\TextEntry::make('asset_identity_no')
                                        ->label('Asset Identity No'),
                                    Components\TextEntry::make('serial_number')
                                        ->label('Serial Number'),
                                    Components\TextEntry::make('code')
                                        ->label('Code'),
                                    Components\TextEntry::make('quantity')
                                        ->label('Quantity'),
                                    Components\TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'available' => 'success',
                                            'loaned' => 'warning',
                                            'damaged' => 'danger',
                                            'lost' => 'danger',
                                            default => 'gray',
                                        }),
                                    Components\TextEntry::make('remark')
                                        ->label('Remarks')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'install' => 'success',
                                            'not yet install' => 'warning',
                                            default => 'gray',
                                        }),
                                ]),
                                Components\Group::make([
                                    Components\TextEntry::make('product.brand')
                                        ->label('Brand'),
                                    Components\TextEntry::make('product.model')
                                        ->label('Model'),
                                    Components\TextEntry::make('user')
                                        ->label('User'),
                                    Components\TextEntry::make('locate.location')
                                        ->label('Location'),
                                    Components\TextEntry::make('locate.building')
                                        ->label('Building'),
                                    Components\TextEntry::make('purchase.voucher_ref')
                                        ->label('Voucher Ref'),
                                    Components\TextEntry::make('purchase.purchase_date')
                                        ->label('Purchase Date')
                                        ->date('d-M-Y'),
                                    Components\TextEntry::make('unit_price')
                                        ->label('Unit Price')
                                        ->money('usd'),
                                ]),
                            ]),
                    ])->from('lg'),
                ]),
            Components\Section::make('Timestamps')
                ->collapsible()
                ->schema([
                    Components\TextEntry::make('created_at')
                        ->label('Created At')
                        ->dateTime('d-M-Y'),
                    Components\TextEntry::make('updated_at')
                        ->label('Last Updated')
                        ->dateTime('d-M-Y '),
                    Components\TextEntry::make('deleted_at')
                        ->label('Deleted At')
                        ->dateTime('d-M-Y ')
                        ->hidden(fn ($record) => $record->deleted_at === null),
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
            'index' => Pages\ListInventories::route('/'),
            // 'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
