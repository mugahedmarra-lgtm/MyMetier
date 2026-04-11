<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\CityResource\Pages;
use App\Models\City;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string | \UnitEnum | null $navigationGroup = 'المواقع';

    protected static ?string $navigationLabel = 'المدن';

    protected static ?string $modelLabel = 'مدينة';

    protected static ?string $pluralModelLabel = 'المدن';
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, $context) {
                        if ($context === 'create' && filled($state)) {
                            $slug = Str::slug($state, '-', 'ar');
                            if (empty($slug)) {
                                $slug = Str::slug($state);
                            }
                            $set('slug', $slug);
                        }
                    }),

                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->default(true)
                    ->required(),

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
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('districts_count')
                    ->label('Districts')
                    ->counts('districts')
                    ->sortable(),

                Tables\Columns\TextColumn::make('professional_profiles_count')
                    ->label('Professionals')
                    ->counts('professionalProfiles')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->filters([
                //
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // Assuming sortably managed natively but leaving room to override
                // we should clear sort_order global scopes if applied from Models
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
