<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ProfessionalProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'professionalProfile';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('display_name')
                    ->required()
                    ->maxLength(255),
                // Minimal structure as requested "Do not build full relation manager UI yet, just prepare structure"
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('display_name')
            ->columns([
                Tables\Columns\TextColumn::make('display_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
