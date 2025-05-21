<?php

namespace App\Filament\Resources\BouquetPhotoResource\Pages;

use App\Filament\Resources\BouquetPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBouquetPhotos extends ListRecords
{
    protected static string $resource = BouquetPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
