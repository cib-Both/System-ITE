<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Room;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
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
                Forms\Components\Section::make('User')
                    ->icon('heroicon-m-user')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->placeholder('Select user')
                            ->required()
                            ->label('User Name')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),
                    ]),
                    Forms\Components\Section::make('Category')
                        ->icon('heroicon-m-archive-box')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->placeholder('Select category')
                                ->required()
                                ->searchable(),                             
                    ]),

                Forms\Components\Section::make('Inventory Details')
                    ->icon('heroicon-m-inbox-stack')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Inventory name or Brand'),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Code of inventory'),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->placeholder('Amount of inventory'),
                        Forms\Components\FileUpload::make('image')
                            ->directory('images')
                            ->image()
                            ->visibility('public'),
                    ])->columns(2),

                Forms\Components\Section::make('Location')
                    ->icon('heroicon-m-building-office')
                    ->schema([
                        Forms\Components\Select::make('room_id')
                            ->placeholder('Select Room, Location')
                            ->label('Room')
                            ->options(Room::all()->mapWithKeys(function ($room) {
                                return [$room->id => "{$room->name}, {$room->Location}"];
                            }))
                            ->required()
                            ->searchable(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->width('40px')
                    ->height('40px'),
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
                Tables\Columns\TextColumn::make('room.Location')
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
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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