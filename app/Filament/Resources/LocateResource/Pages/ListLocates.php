<?php

namespace App\Filament\Resources\LocateResource\Pages;

use App\Filament\Resources\LocateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;

class ListLocates extends ListRecords
{
    protected static string $resource = LocateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Locate')
                ->icon('heroicon-o-plus')
                ->iconPosition(IconPosition::After),
        ];
    }
}
