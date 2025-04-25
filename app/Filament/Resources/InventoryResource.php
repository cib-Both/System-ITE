<?php

namespace App\Filament\Resources;

use App\Filament\Exports\InventoryExporter;
use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
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
use Filament\Support\Enums\IconPosition;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Inventory Information')
                    ->columns(2)
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
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1),
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
                                ])
                                ->default('available')
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
                Tables\Columns\TextColumn::make('product.brand')
                    ->searchable()
                    ->label('Product Brand'),
                Tables\Columns\TextColumn::make('product.model')
                    ->searchable()
                    ->label('Product Model'),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->label('Serial Number'),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable()
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state): ?string => match ($state) {
                        'available' => 'heroicon-m-check-circle',
                        'loaned' => 'heroicon-m-arrow-up-on-square-stack',
                        'damaged' => 'heroicon-m-exclamation-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'loaned' => 'warning',
                        'damaged' => 'danger',
                    }),
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
                //
            ])
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
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
