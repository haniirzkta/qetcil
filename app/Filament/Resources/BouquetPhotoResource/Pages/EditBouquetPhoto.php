<?php

namespace App\Filament\Resources\BouquetPhotoResource\Pages;

use App\Filament\Resources\BouquetPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBouquetPhoto extends EditRecord
{
    protected static string $resource = BouquetPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
