<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return[
            'All' => Tab::make()
                ->icon('heroicon-m-users')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => User::count()),
                

            'Has Role' => Tab::make()
                ->icon('heroicon-m-lock-closed')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => User::whereHas('roles')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles')),

            'No Role' => Tab::make()
                ->icon('heroicon-m-lock-open')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => User::whereDoesntHave('roles')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDoesntHave('roles')),

            'Trash' => Tab::make()
                ->icon('heroicon-m-trash')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => User::onlyTrashed()->count()) 
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),

        ];
    }
}
