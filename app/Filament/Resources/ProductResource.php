<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->columns(2)
                    ->schema([
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->placeholder('Select Supplier')
                            ->relationship('supplier', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Supplier Name')
                                    ->placeholder('Full Name')
                                    ->required(),
                            ])    
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required(),
                        Select::make('category_id')
                            ->label('Category')
                            ->placeholder('Select Category')
                            ->relationship('category', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('Category name'),
                                Textarea::make('description')
                                    ->placeholder('Description')
                                    ->columnSpanFull()
                                    ->autosize()
                            ])
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required(),
                        TextInput::make('brand')
                            ->label('Product brand')
                            ->placeholder('Product Brand')
                            ->required(),
                        TextInput::make('model')
                            ->label('Product Model')
                            ->placeholder('Product Model')
                            ->required(),
                        Textarea::make('spec')
                            ->label('Spec')
                            ->placeholder('Specification')
                            ->autosize(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->label('Supplier'),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->label('Category'),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->label('Brand'),
                Tables\Columns\TextColumn::make('model')
                    ->searchable()
                    ->label('Model'),
                Tables\Columns\TextColumn::make('spec')
                    ->searchable()
                    ->label('Specification'),
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
                    Tables\Actions\DeleteAction::make()
                ])
                ->tooltip('Actions'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
