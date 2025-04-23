<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\Purchase;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListPurchases extends ListRecords
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create Purchase')
                ->icon('heroicon-o-plus')
                ->iconPosition(IconPosition::After),
        ];
    }

    public function getTabs(): array
    {
        return[
            'All' => Tab::make()
                ->icon('heroicon-m-arrow-up-on-square-stack')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Purchase::count()),         

            'Delivered' => Tab::make()
                ->icon('heroicon-m-check-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Purchase::where('status', '=', 'delivered')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'delivered')),
    
            'Pending' => Tab::make()
                ->icon('heroicon-m-clock')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Purchase::where('status', '=', 'pending')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'pending')),

            'Cancelled' => Tab::make()
                ->icon('heroicon-m-x-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Purchase::where('status', '=', 'cancelled')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'cancelled')),
         ];
        }
    }
    
