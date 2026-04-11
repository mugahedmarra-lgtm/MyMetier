<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfessionalProfileResource\Pages;
use App\Filament\Resources\ProfessionalProfileResource\RelationManagers;
use BackedEnum;
use App\Models\ProfessionalProfile;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProfessionalProfileResource extends Resource
{
    protected static ?string $model = ProfessionalProfile::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    protected static string | \UnitEnum | null $navigationGroup = 'المهنيين';

    protected static ?string $navigationLabel = 'حسابات مقدمي الخدمات';

    protected static ?string $modelLabel = 'حساب مقدم خدمة';

    protected static ?string $pluralModelLabel = 'حسابات مقدمي الخدمات';

    protected static ?int $navigationSort = 3;

    // Disable creating manually as per instructions
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * Badge showing total operational accounts.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = ProfessionalProfile::where('profile_status', '!=', 'pending_review')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    /**
     * Scope to operational accounts only — exclude pending_review
     * which belongs to the separate Upgrade Requests queue.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('profile_status', '!=', 'pending_review');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Basic Info')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->required(),
                            
                        TextInput::make('display_name')
                            ->required()
                            ->maxLength(255),

                        Select::make('provider_type')
                            ->options([
                                'professional' => 'Professional',
                                'contractor' => 'Contractor',
                            ])
                            ->disabled()
                            ->label('Provider Type'),
                            
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Profession & Location')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name', fn (Builder $query) => $query->where('is_active', true))
                            ->required()
                            ->searchable()
                            ->preload(),
                            
                        Select::make('city_id')
                            ->relationship('city', 'name', fn (Builder $query) => $query->where('is_active', true))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(), // Ensures district query reacts to city change
                            
                        Select::make('district_id')
                            ->relationship('district', 'name', fn (Builder $query, Get $get) => 
                                $query->where('city_id', $get('city_id'))->where('is_active', true)
                            )
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->columns(3),

                Section::make('Contact & Status')
                    ->schema([
                        TextInput::make('whatsapp_number')
                            ->required()
                            ->maxLength(255),
                            
                        Select::make('availability_status')
                            ->options([
                                'available' => 'Available',
                                'busy' => 'Busy',
                                'offline' => 'Offline',
                            ])
                            ->required(),
                            
                        Select::make('verification_status')
                            ->options([
                                'unverified' => 'Unverified',
                                'verified' => 'Verified',
                            ])
                            ->required(),
                            
                        Select::make('profile_status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                            
                        TextInput::make('gallery_limit_override')
                            ->label('Gallery Limit Override')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->helperText('Override the allowed image limit. Null = use default policy (Verified: 10, Unverified: 3). If set, this exact value becomes the final maximum limit.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Stats (Read Only)')
                    ->schema([
                        TextInput::make('rating_avg')
                            ->disabled(),
                            
                        TextInput::make('rating_count')
                            ->disabled(),
                            
                        TextInput::make('views_count')
                            ->disabled(),
                            
                        TextInput::make('whatsapp_clicks')
                            ->disabled(),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('display_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('provider_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'professional' => 'info',
                        'contractor' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (?string $state): string => match ($state) {
                        'professional' => 'heroicon-m-wrench-screwdriver',
                        'contractor' => 'heroicon-m-building-office',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'professional' => 'Professional',
                        'contractor' => 'Contractor',
                        default => '—',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('availability_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'busy' => 'warning',
                        'offline' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('verification_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'unverified' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'verified' => 'heroicon-m-check-badge',
                        'unverified' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('profile_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'suspended' => 'danger',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating_avg')
                    ->label('Rating')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('reviews_count')
                    ->label('Reviews')
                    ->counts('reviews')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('provider_type')
                    ->options([
                        'professional' => 'Professional',
                        'contractor' => 'Contractor',
                    ])
                    ->label('Provider Type'),

                Tables\Filters\SelectFilter::make('profile_status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('verification_status')
                    ->options([
                        'unverified' => 'Unverified',
                        'verified' => 'Verified',
                    ]),

                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name', fn (Builder $query) => $query->where('is_active', true))
                    ->label('Category'),
                    
                Tables\Filters\SelectFilter::make('city_id')
                    ->relationship('city', 'name', fn (Builder $query) => $query->where('is_active', true))
                    ->label('City'),
            ])
            ->recordActions([
                // ── Quick Status Actions (grouped) ─────────────
                ActionGroup::make([
                    Action::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Activate Provider')
                        ->modalDescription('Are you sure you want to activate this provider account? Their profile will become publicly visible.')
                        ->modalSubmitActionLabel('Yes, Activate')
                        ->action(fn (ProfessionalProfile $record) => $record->update(['profile_status' => 'active']))
                        ->visible(fn (ProfessionalProfile $record) => $record->profile_status !== 'active')
                        ->successNotificationTitle('Provider activated successfully.'),

                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-m-pause-circle')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate Provider')
                        ->modalDescription('Are you sure you want to deactivate this provider? Their profile will be hidden from search.')
                        ->modalSubmitActionLabel('Yes, Deactivate')
                        ->action(fn (ProfessionalProfile $record) => $record->update(['profile_status' => 'inactive']))
                        ->visible(fn (ProfessionalProfile $record) => !in_array($record->profile_status, ['inactive', 'suspended']))
                        ->successNotificationTitle('Provider deactivated.'),

                    Action::make('suspend')
                        ->label('Suspend')
                        ->icon('heroicon-m-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Suspend Provider')
                        ->modalDescription('Are you sure you want to suspend this provider? They will lose all public visibility and access.')
                        ->modalSubmitActionLabel('Yes, Suspend')
                        ->action(fn (ProfessionalProfile $record) => $record->update(['profile_status' => 'suspended']))
                        ->visible(fn (ProfessionalProfile $record) => $record->profile_status !== 'suspended')
                        ->successNotificationTitle('Provider suspended.'),

                    Action::make('contact_whatsapp')
                        ->label('WhatsApp')
                        ->icon('heroicon-m-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(fn (ProfessionalProfile $record) =>
                            'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->whatsapp_number)
                        )
                        ->openUrlInNewTab(),
                ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('gray'),

                // ── Standard CRUD ──────────────────────────────
                ViewAction::make(),
                EditAction::make(),
                
                // ── Cross-Links ────────────────────────────────
                Action::make('view_verification')
                    ->label('Verification History')
                    ->icon('heroicon-m-shield-check')
                    ->color('info')
                    ->url(fn (ProfessionalProfile $record) => 
                        $record->latestVerificationRequest 
                            ? \App\Filament\Resources\VerificationRequestResource::getUrl('view', ['record' => $record->latestVerificationRequest->id]) 
                            : null
                    )
                    ->visible(fn (ProfessionalProfile $record) => $record->latestVerificationRequest !== null)
                    ->openUrlInNewTab(),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class,
            RelationManagers\GalleryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfessionalProfiles::route('/'),
            'view' => Pages\ViewProfessionalProfile::route('/{record}'),
            'edit' => Pages\EditProfessionalProfile::route('/{record}/edit'),
        ];
    }
}
