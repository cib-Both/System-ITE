<?php

namespace App\Filament\Resources\LocateResource\Pages;

use App\Filament\Resources\LocateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocate extends CreateRecord
{
    protected static string $resource = LocateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
