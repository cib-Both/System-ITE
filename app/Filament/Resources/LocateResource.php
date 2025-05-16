<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocateResource\Pages;
use App\Filament\Resources\LocateResource\RelationManagers;
use App\Models\Locate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocateResource extends Resource
{
    protected static ?string $model = Locate::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?int $navigationSort = 5;
    public static function getGloballySearchableAttributes(): array
    {
    return [
        'location',
        'building',
    ];
    }
        public static function getGlobalSearchResultDetails($record): array
    {
    return [
        'Location' => $record->location,
        'Building' => $record->building,
    ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Locate Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->label('Location and Condition')
                            ->required(),
                        Forms\Components\TextInput::make('building')
                            ->label('Building')
                            ->placeholder('Building')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('building')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListLocates::route('/'),
            'create' => Pages\CreateLocate::route('/create'),
            'edit' => Pages\EditLocate::route('/{record}/edit'),
        ];
    }
}
