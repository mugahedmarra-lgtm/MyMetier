<?php

namespace App\Filament\Resources\GalleryLimitRequests\Pages;

use App\Filament\Resources\GalleryLimitRequests\GalleryLimitRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGalleryLimitRequest extends EditRecord
{
    protected static string $resource = GalleryLimitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
