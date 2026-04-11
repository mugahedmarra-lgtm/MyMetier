<?php

namespace App\Filament\Resources\ProfessionalGalleryResource\Pages;

use App\Filament\Resources\ProfessionalGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfessionalGalleries extends ListRecords
{
    protected static string $resource = ProfessionalGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
