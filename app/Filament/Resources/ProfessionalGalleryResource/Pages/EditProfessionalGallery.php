<?php

namespace App\Filament\Resources\ProfessionalGalleryResource\Pages;

use App\Filament\Resources\ProfessionalGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfessionalGallery extends EditRecord
{
    protected static string $resource = ProfessionalGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
