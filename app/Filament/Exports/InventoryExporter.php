<?php

namespace App\Filament\Exports;

use App\Models\Inventory;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class InventoryExporter extends Exporter
{
    protected static ?string $model = Inventory::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('class_of_asset')
                ->label('Class of Asset'),
            ExportColumn::make('asset_identity_no')
                ->label('Asset Identity No'),
            ExportColumn::make('product.category.name')
                ->label('Category'),
            ExportColumn::make('product.brand')
                ->label('Brand'),
            ExportColumn::make('product.model')
                ->label('Product'),
            ExportColumn::make('product.spec')
                ->label('Specification'),
            ExportColumn::make('serial_number'),
            ExportColumn::make('purchase.purchase_date')
                ->label('Purchase Date'),
            ExportColumn::make('purchase.voucher_ref')
                ->label('Voucher Ref'),
            ExportColumn::make('quantity'),
            ExportColumn::make('unit_price')
                ->label('Unit Price'),
            ExportColumn::make('user')
                ->label('User'),
            ExportColumn::make('locate.location')
                ->label('Location and Condition '),
            ExportColumn::make('locate.building')
                ->label('Building'),
            ExportColumn::make('remark')
                ->label('Remark'),
            ExportColumn::make('status'),
            ExportColumn::make('code')
                ->label('Code'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your inventory export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
