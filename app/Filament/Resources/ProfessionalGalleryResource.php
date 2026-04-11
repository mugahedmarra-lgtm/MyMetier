<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\ProfessionalGalleryResource\Pages;
use App\Models\ProfessionalGallery;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProfessionalGalleryResource extends Resource
{
    protected static ?string $model = ProfessionalGallery::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-photo';

    protected static string | \UnitEnum | null $navigationGroup = 'المحتوى';
    
    protected static ?string $navigationLabel = 'معارض الأعمال';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('professional_profile_id')
                    ->relationship('professionalProfile', 'display_name')
                    ->label('Professional Profile')
                    ->required()
                    ->searchable()
                    ->preload(),

                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->directory('galleries')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('title')
                    ->maxLength(255),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('professionalProfile.display_name')
                    ->label('Professional')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image_path')
                    ->label('Preview')
                    ->imageSize(60)
                    ->square(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No Title'),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->filters([
                SelectFilter::make('professional_profile_id')
                    ->relationship('professionalProfile', 'display_name')
                    ->label('Professional Profile')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfessionalGalleries::route('/'),
            'create' => Pages\CreateProfessionalGallery::route('/create'),
            'edit' => Pages\EditProfessionalGallery::route('/{record}/edit'),
        ];
    }
}
