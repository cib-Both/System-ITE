<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;

class UserOverview extends BaseWidget
{
    protected static ?string $heading = 'New Users';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::where('created_at', '>=', Carbon::now()->subDays(30))->latest()
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d-M-Y'),
            ]);
    }

}