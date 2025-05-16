<?php

namespace App\Filament\Resources;

use App\Filament\Exports\LoanExporter;
use App\Filament\Resources\LoanResource\Pages;
use App\Filament\Resources\LoanResource\RelationManagers;
use App\Models\Inventory;
use App\Models\Loan;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\SelectColumn;



class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';
    protected static ?string $navigationGroup = 'Transaction';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';
    public static function getGlobalSearchResultDetails($record): array
{
    return [
        'Position' => $record->position,
        'Department' => $record->department->name,
    ];
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Loaner Information')
                    ->columns(4)
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->placeholder('Full Name')
                            ->required(),
                        TextInput::make('position')
                            ->label('Position')
                            ->placeholder('Position')
                            ->required(),
                        TextInput::make('phone_number')
                            ->label('Phone')
                            ->placeholder('Phone Number'),
                        Select::make('department_id')
                            ->label('Department')
                            ->placeholder('Select Department')
                            ->relationship('department', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Department Name')
                                    ->placeholder('Department Name')
                                    ->required(),
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                    ]),
                                  
                Section::make('Loan')
                    ->columns(3)
                    ->schema([
                        Select::make('inventory_id')
                            ->label('Serial Number')
                            ->placeholder('Select Serial Number')
                            ->relationship('inventory', 'serial_number')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $inventory = Inventory::find($state);
                                    if ($inventory) {
                                        $set('product_brand', $inventory->product->brand);
                                        $set('product_model', $inventory->product->model);
                                    }
                                } else {
                                    $set('product_brand', null);
                                    $set('product_model', null);
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set) {
                                if ($state) {
                                    $inventory = Inventory::find($state);
                                    if ($inventory) {
                                        $set('product_brand', $inventory->product->brand);
                                        $set('product_model', $inventory->product->model);
                                    }
                                }
                            }),
                            TextInput::make('product_brand')
                            ->label('Brand')
                            ->placeholder('Product Brand')
                            ->disabled()
                            ->required(),                       
                            TextInput::make('product_model')
                            ->label('Model')
                            ->placeholder('Product Model')
                            ->disabled()
                            ->required(),
                        ]),

                Section::make('Date')
                        ->columns(2)
                        ->description('Return date do not neet to fill if the product is not returned yet.')
                        ->schema([
                                DatePicker::make('loan_date')
                                    ->label('Loan Date')
                                    ->required()
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->displayFormat('M, d, Y')
                                    ->placeholder('MM/DD/YYYY'),
                                DatePicker::make('return_date')
                                    ->label('Return Date')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->displayFormat('M, d, Y')
                                    ->placeholder('MM/DD/YYYY'),
                    ]),

                Split::make([
                    Section::make()
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->native(false)
                            ->options([
                                'active' => 'Active',
                                'returned' => 'Returned',
                            ])
                            ->default('active'),
                    ])
                ])             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
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
                Tables\Columns\TextColumn::make('inventory.product.category.name')
                    ->searchable()
                    ->label('Category'),
                Tables\Columns\TextColumn::make('inventory.product.brand')
                    ->searchable()
                    ->label('Brand'),
                Tables\Columns\TextColumn::make('inventory.product.model')
                    ->searchable()
                    ->label('Model'),
                Tables\Columns\TextColumn::make('inventory.serial_number')
                    ->searchable()
                    ->label('Serial Number'),
                Tables\Columns\TextColumn::make('inventory.quantity')
                    ->searchable()
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('loan_date')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('return_date')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('delete_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->icon(fn (string $state): ?string => match ($state) {
                        'active' => 'heroicon-m-play',
                        'returned' => 'heroicon-m-arrow-uturn-left',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'warning',
                        'returned' => 'success',
                    }),
            ])
            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make()
                ])
                ->tooltip('Actions'),
                Tables\Actions\RestoreAction::make(), 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make()
                ]),
                Tables\Actions\ExportBulkAction::make()
                    ->label('Export')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->iconPosition(IconPosition::After)
                    ->exporter(LoanExporter::class)
                    ->color('success'),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
