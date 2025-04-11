<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Exports\LoanExporter;
use App\Filament\Resources\LoanResource;
use App\Models\Loan;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(LoanExporter::class)
                ->icon('heroicon-m-arrow-down-tray')
                ->iconPosition(IconPosition::After)
                ->label('Export')
                ->color('success'),
            Actions\CreateAction::make()
                ->icon('heroicon-m-plus')
                ->iconPosition(IconPosition::After)
                ->label('Create Loan'),
        ];
    }

    public function getTabs(): array
    {
        return[
            'All' => Tab::make()
                ->icon('heroicon-m-arrow-up-on-square-stack')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Loan::count()),         

            'Active' => Tab::make()
                ->icon('heroicon-m-play')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Loan::where('status', '=', 'active')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'active')),
    
            'Return' => Tab::make()
                ->icon('heroicon-m-arrow-uturn-left')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Loan::where('status', '=', 'returned')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'returned')),

            'Trash' => Tab::make()
                ->icon('heroicon-m-trash')
                ->iconPosition(IconPosition::Before)
                ->badge(fn () => Loan::onlyTrashed()->count()) 
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),

        ];
    }
}
