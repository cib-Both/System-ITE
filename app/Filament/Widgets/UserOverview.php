<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserOverview extends BaseWidget
{
    protected static ?string $heading = 'New Users';
    protected static ?int $sort = 3;
     protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->roles->contains('name', 'admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->url(fn (User $record): string => UserResource::getUrl('edit', ['record' => $record])),
                TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->url(fn (User $record): string => UserResource::getUrl('edit', ['record' => $record])),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->icon('heroicon-m-shield-check')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d-M-Y'),
            ]);
    }

}