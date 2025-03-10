<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Role;
use Doctrine\DBAL\Query\From;
use Faker\Core\Color;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Users Settings';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Role Details')
            ->icon('heroicon-m-shield-check')
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Role name')
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),

                Select::make('permissions')
                    ->multiple()
                    ->relationship('permissions', 'id')
                    ->preload()
                    ->options(function () {
                        return [
                            'Category Permissions' => Permission::where('name', 'like', '%Category%')
                                ->pluck('name', 'id')
                                ->toArray(),
                            'Inventory Permissions' => Permission::where('name', 'like', '%Inventory%')
                                ->pluck('name', 'id')
                                ->toArray(),
                            'Room Permissions' => Permission::where('name', 'like', '%Room%')
                                ->pluck('name', 'id')
                                ->toArray(),
                        ];
                    })
                    ->label('Permissions')
                    ->searchable(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->badge()
                ->sortable()
                ->searchable(),
                TextColumn::make('guard_name')
                ->color('primary'),
                TextColumn::make('created_at')
                ->dateTime('d-M-Y'),
                TextColumn::make('updated_at')
                ->dateTime('d-M-Y'),        
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('name', '!=', 'admin');
    }
 
}
