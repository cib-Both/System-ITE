<?php

namespace App\Filament\Exports;

use App\Models\Loan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class LoanExporter extends Exporter
{
    protected static ?string $model = Loan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('department.name')
                ->label('Department'),
            ExportColumn::make('position'),
            ExportColumn::make('inventory.product.category.name')
                ->label('Category'),
            ExportColumn::make('inventory.product.brand')
                ->label('Brand'),
            ExportColumn::make('inventory.product.model')
                ->label('Model'),
            ExportColumn::make('inventory.serial_number')
                ->label('Serial Number'),
            ExportColumn::make('inventory.quantity')
                ->label('Quantity'),
            ExportColumn::make('phone_number'),
            ExportColumn::make('loan_date'),
            ExportColumn::make('return_date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your loan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
