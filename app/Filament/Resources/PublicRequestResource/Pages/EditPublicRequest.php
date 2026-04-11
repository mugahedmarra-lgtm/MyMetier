<?php

namespace App\Filament\Resources\PublicRequestResource\Pages;

use App\Filament\Resources\PublicRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicRequest extends EditRecord
{
    protected static string $resource = PublicRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
