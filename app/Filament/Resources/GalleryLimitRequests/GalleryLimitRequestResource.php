<?php

namespace App\Filament\Resources\GalleryLimitRequests;

use App\Filament\Resources\GalleryLimitRequests\Pages\CreateGalleryLimitRequest;
use App\Filament\Resources\GalleryLimitRequests\Pages\EditGalleryLimitRequest;
use App\Filament\Resources\GalleryLimitRequests\Pages\ListGalleryLimitRequests;
use App\Filament\Resources\GalleryLimitRequests\Schemas\GalleryLimitRequestForm;
use App\Filament\Resources\GalleryLimitRequests\Tables\GalleryLimitRequestsTable;
use App\Models\GalleryLimitRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GalleryLimitRequestResource extends Resource
{
    protected static ?string $model = GalleryLimitRequest::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-plus';
    
    protected static ?string $navigationLabel = 'طلبات السعة';
    
    protected static ?string $modelLabel = 'طلب سعة المعرض';
    
    protected static ?string $pluralModelLabel = 'طلبات زيادة سعة المعرض';
    
    protected static string | \UnitEnum | null $navigationGroup = 'المهنيين';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return GalleryLimitRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryLimitRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleryLimitRequests::route('/'),
            'create' => CreateGalleryLimitRequest::route('/create'),
            'edit' => EditGalleryLimitRequest::route('/{record}/edit'),
        ];
    }
}
