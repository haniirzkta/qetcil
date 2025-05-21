<?php

namespace App\Filament\Resources\BouquetTransactionResource\Pages;

use App\Filament\Resources\BouquetTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBouquetTransaction extends EditRecord
{
    protected static string $resource = BouquetTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
