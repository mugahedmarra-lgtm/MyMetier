<?php

namespace App\Filament\Resources\PublicRequestResource\Pages;

use App\Filament\Resources\PublicRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPublicRequest extends ViewRecord
{
    protected static string $resource = PublicRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
