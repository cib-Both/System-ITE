<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Role;

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
                        TextInput::make('guard_name')
                            ->label('Guard Name')
                            ->required()
                            ->disabled()
                            ->default('web'),
                        ])->columns(2),
               
                Section::make('User')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%User%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Role')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Role%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Category')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Category%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),

                Section::make('Inventory')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Inventory%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Loan')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Loan%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Product')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Product%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Department')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Department%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Supplier')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Supplier%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
                Section::make('Purchase')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'id')
                            ->options(Permission::where('name', 'like', '%Purchase%')->pluck('name', 'id')->toArray())
                            ->label('Permissions')
                            ->bulkToggleable()
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('name')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissions')
                    ->sortable()
                    ->badge(),
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