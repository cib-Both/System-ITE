<?php

namespace App\Filament\Resources\InventoryResource\Widgets;

use App\Models\Inventory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InventoryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total', Inventory::count()),
            Stat::make('Loan', Inventory::where('status', 'loaned')->count()),
            Stat::make('Available', Inventory::where('status', 'available')->count()),
            Stat::make('Not yet install', Inventory::where('remark', 'not yet install')->count()),
        ];
    }
}
