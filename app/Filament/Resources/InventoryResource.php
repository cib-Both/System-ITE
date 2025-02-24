<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\Section::make('Inventory Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Dell, Imac, etc'),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Inventory code'),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->placeholder('Quantity of inventory'),
                        Forms\Components\FileUpload::make('image')
                            ->image(),
                    ]),
                Forms\Components\Section::make('Category')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(Category::all()->pluck('name', 'id'))
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('Category name'),
                                Forms\Components\Textarea::make('description')
                                    ->placeholder('Category description')
                                    ->columnSpanFull()
                                    ->autosize(),
                            ])
                            ->required(),
                    ]),
                Forms\Components\Section::make('Location')
                    ->schema([
                        Forms\Components\Select::make('room_id')
                            ->label('Room')
                            ->options(Room::all()->mapWithKeys(function ($room) {
                                return [$room->id => "{$room->name}, {$room->Location}"];
                            }))
                            ->required()
                            ->searchable(),
                    ]),
                Forms\Components\Section::make('User')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->required()
                            ->label('User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.roles.name')
                    ->label('Role'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('Room')
                    ->searchable(),
                Tables\Columns\TextColumn::make('room.location')
                    ->label('Location')
                    ->searchable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}