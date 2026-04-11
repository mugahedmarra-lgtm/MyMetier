<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\PublicRequestResource\Pages;
use App\Models\PublicRequest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PublicRequestResource extends Resource
{
    protected static ?string $model = PublicRequest::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static string | \UnitEnum | null $navigationGroup = 'التفاعلات';

    protected static ?string $navigationLabel = 'الطلبات العامة';

    protected static ?string $modelLabel = 'طلب عام';

    protected static ?string $pluralModelLabel = 'الطلبات العامة';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('User Info (Read Only)')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->label('User Name'),
                    ]),

                Section::make('Request Info')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                            
                        Textarea::make('description')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),

                Section::make('Classification')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name', fn (Builder $query) => $query->where('is_active', true))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Category'),
                            
                        Select::make('city_id')
                            ->relationship('city', 'name', fn (Builder $query) => $query->where('is_active', true))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->label('City'),
                            
                        Select::make('district_id')
                            ->relationship('district', 'name', fn (Builder $query, Get $get) => 
                                $query->where('city_id', $get('city_id'))->where('is_active', true)
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('District'),
                    ])->columns(3),

                Section::make('Status')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'closed' => 'Closed',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                TextColumn::make('city.name')
                    ->label('City')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                    ]),
                    
                SelectFilter::make('category_id')
                    ->relationship('category', 'name', fn (Builder $query) => $query->where('is_active', true))
                    ->label('Category')
                    ->searchable()
                    ->preload(),
                    
                SelectFilter::make('city_id')
                    ->relationship('city', 'name', fn (Builder $query) => $query->where('is_active', true))
                    ->label('City')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => Pages\ListPublicRequests::route('/'),
            'view' => Pages\ViewPublicRequest::route('/{record}'),
            'edit' => Pages\EditPublicRequest::route('/{record}/edit'),
        ];
    }
}
