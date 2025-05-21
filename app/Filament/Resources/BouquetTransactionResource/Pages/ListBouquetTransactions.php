<?php

namespace App\Filament\Resources\BouquetTransactionResource\Pages;

use App\Filament\Resources\BouquetTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBouquetTransactions extends ListRecords
{
    protected static string $resource = BouquetTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
