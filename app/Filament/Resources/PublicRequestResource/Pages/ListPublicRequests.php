<?php

namespace App\Filament\Resources\PublicRequestResource\Pages;

use App\Filament\Resources\PublicRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublicRequests extends ListRecords
{
    protected static string $resource = PublicRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Creating is disabled explicitly
        ];
    }
}
