<?php

namespace App\Filament\Resources\LocateResource\Pages;

use App\Filament\Resources\LocateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocate extends EditRecord
{
    protected static string $resource = LocateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
