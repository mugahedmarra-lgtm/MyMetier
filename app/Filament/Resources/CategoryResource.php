<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static string | \UnitEnum | null $navigationGroup = 'التصنيفات';

    protected static ?string $navigationLabel = 'التصنيفات';

    protected static ?string $modelLabel = 'تصنيف';

    protected static ?string $pluralModelLabel = 'التصنيفات';

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
                            // Basic translation fallback, actual unique constraint generation 
                            // is safely backed up by the Model events
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

                TextInput::make('icon')
                    ->nullable()
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

                Tables\Columns\TextColumn::make('icon')
                    ->icon(fn ($state) => $state)
                    ->toggleable(isToggledHiddenByDefault: true),

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
                DeleteAction::make()
                    ->before(function (DeleteAction $action, Category $record) {
                        if ($record->professionalProfiles()->exists()) {
                            // Soft deletion logic only, but prevent physical hard deletes 
                            // This depends strictly on soft deletes being registered
                            // Filament respects the SoftDeletes trait automatically
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        // By disabling the global order scope, we allow Filament's sorting and reordering 
        // functionalities to work correctly inside the data table views. 
        return parent::getEloquentQuery()
            ->withoutGlobalScope('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
