<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\DistrictResource\Pages;
use App\Models\District;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-map';

    protected static string | \UnitEnum | null $navigationGroup = 'المواقع';

    protected static ?string $navigationLabel = 'الأحياء';

    protected static ?string $modelLabel = 'حي';

    protected static ?string $pluralModelLabel = 'الأحياء';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('city_id')
                    ->relationship(
                        name: 'city',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live(),

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
                    ->unique('districts', 'slug', ignoreRecord: true, modifyRuleUsing: function (Unique $rule, Get $get) {
                        return $rule->where('city_id', $get('city_id'));
                    })
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->default(true)
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

                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city_id')
                    ->relationship('city', 'name', fn (Builder $query) => $query->where('is_active', true))
                    ->label('City')
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
            'index' => Pages\ListDistricts::route('/'),
            'create' => Pages\CreateDistrict::route('/create'),
            'edit' => Pages\EditDistrict::route('/{record}/edit'),
        ];
    }
}
