<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Exports\InventoryExporter;
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
            Actions\ExportAction::make()
                ->exporter(InventoryExporter::class)
                ->icon('heroicon-m-arrow-down-tray')
                ->iconPosition(IconPosition::After)
                ->label('Export')
                ->color('success'),
            Actions\CreateAction::make()
                ->icon('heroicon-m-plus')
                ->iconPosition(IconPosition::After)
                ->label('Add Inventory'),
        ];
    }


    public function getTabs(): array
    {
        return[
            'All' => Tab::make()
                ->icon('heroicon-m-inbox-stack')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::count()),         

            'Available' => Tab::make()
                ->icon('heroicon-m-check-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::where('status', '=', 'available')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'available')),
    
            'Loan' => Tab::make()
                ->icon('heroicon-m-arrow-up-on-square-stack')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::where('status', '=', 'loaned')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'loaned')),

            'Damage' => Tab::make()
                ->icon('heroicon-m-exclamation-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::where('status', '=', 'damaged')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'damaged')),

            'Lost' => Tab::make()
                ->icon('heroicon-m-no-symbol')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::where('status', '=', 'lost')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'lost')),

            'Trash' => Tab::make()
                ->icon('heroicon-m-trash')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Inventory::onlyTrashed()->count()) 
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),

        ];
    }

}
