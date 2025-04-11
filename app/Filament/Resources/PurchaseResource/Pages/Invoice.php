<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Resources\Pages\Page;
use App\Models\Purchase;
use Carbon\Carbon;



class Invoice extends Page
{
    protected static string $resource = PurchaseResource::class;

    protected static string $view = 'filament.resources.purchase-resource.pages.invoice';

    public Purchase $purchase;

    public function mount($record): void
    {
        $this->purchase = Purchase::with(['product.product', 'supplier'])->findOrFail($record);

        $this->purchase->purchase_date = Carbon::parse($this->purchase->purchase_date);
        $this->purchase->product = $this->purchase->product ?? collect();
    }
}