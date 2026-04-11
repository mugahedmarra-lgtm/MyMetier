<?php

namespace App\Filament\Resources\ProfessionalProfileResource\Pages;

use App\Filament\Resources\ProfessionalProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProfessionalProfile extends ViewRecord
{
    protected static string $resource = ProfessionalProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
