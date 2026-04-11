<?php

namespace App\Filament\Resources\ProfessionalProfileResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryRelationManager extends RelationManager
{
    protected static string $relationship = 'gallery';

    protected static ?string $title = 'Professional Gallery';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Preview')
                    ->imageSize(80)
                    ->square(),
                    
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No Title'),
                    
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->disabled(fn () => !$this->getOwnerRecord()->canUploadMoreGalleryImages())
                    ->tooltip(fn () => !$this->getOwnerRecord()->canUploadMoreGalleryImages() 
                        ? 'Limit reached (' . $this->getOwnerRecord()->getGalleryLimit() . ' images max). Delete older images to add new ones.' 
                        : null),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }
}
