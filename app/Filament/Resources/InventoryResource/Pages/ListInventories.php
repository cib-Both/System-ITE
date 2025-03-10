<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Inventory;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

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
                ->icon('heroicon-m-inbox-stack')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::count()),

            'Trash' => Tab::make()
                ->icon('heroicon-m-trash')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::onlyTrashed()->count()) 
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),
  
        ];
    }
}
