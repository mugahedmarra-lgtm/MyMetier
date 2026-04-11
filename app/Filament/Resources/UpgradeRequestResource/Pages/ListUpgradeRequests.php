<?php

namespace App\Filament\Resources\UpgradeRequestResource\Pages;

use App\Filament\Resources\UpgradeRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListUpgradeRequests extends ListRecords
{
    protected static string $resource = UpgradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
