<?php

namespace App\Filament\Resources\GalleryLimitRequests\Pages;

use App\Filament\Resources\GalleryLimitRequests\GalleryLimitRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGalleryLimitRequests extends ListRecords
{
    protected static string $resource = GalleryLimitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
