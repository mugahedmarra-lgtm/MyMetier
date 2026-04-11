<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\UpgradeRequestResource\Pages;
use App\Models\ProfessionalProfile;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UpgradeRequestResource extends Resource
{
    protected static ?string $model = ProfessionalProfile::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-arrow-up-circle';

    protected static string | \UnitEnum | null $navigationGroup = 'المهنيين';

    protected static ?string $navigationLabel = 'طلبات الترقية';

    protected static ?string $modelLabel = 'طلب ترقية';

    protected static ?string $pluralModelLabel = 'طلبات الترقية';

    protected static ?string $slug = 'upgrade-requests';

    protected static ?int $navigationSort = 1;

    /**
     * Disable manual creation — records come from the upgrade flow only.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * Disable editing from this resource — admin should use the main
     * ProfessionalProfileResource for edits.
     */
    public static function canEdit($record): bool
    {
        return false;
    }

    /**
     * Disable deletion from this queue.
     */
    public static function canDelete($record): bool
    {
        return false;
    }

    /**
     * Badge showing the count of pending requests in the sidebar.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = ProfessionalProfile::where('profile_status', 'pending_review')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    /**
     * Base query: only pending_review profiles.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('profile_status', 'pending_review');
    }

    /**
     * Infolist schema for the dedicated review details page.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ── Section 1: Applicant / Account Data ─────────────
                Section::make('Applicant Information')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Account Name'),

                        TextEntry::make('display_name')
                            ->label('Display Name'),

                        TextEntry::make('user.phone')
                            ->label('Primary Phone'),

                        TextEntry::make('secondary_phone')
                            ->label('Secondary Phone')
                            ->default('—'),

                        TextEntry::make('provider_type')
                            ->label('Provider Type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'professional' => 'info',
                                'contractor' => 'success',
                                default => 'gray',
                            }),

                        TextEntry::make('gender')
                            ->label('Gender')
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'male' => 'Male',
                                'female' => 'Female',
                                default => '—',
                            }),

                        TextEntry::make('created_at')
                            ->label('Submission Date')
                            ->dateTime(),
                    ])->columns(3),

                // ── Section 2: Professional Profile Data ────────────
                Section::make('Professional Profile')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        TextEntry::make('category.name')
                            ->label('Category / Service'),

                        TextEntry::make('city.name')
                            ->label('City'),

                        TextEntry::make('district.name')
                            ->label('District')
                            ->default('—'),

                        TextEntry::make('whatsapp_number')
                            ->label('WhatsApp Number'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),

                        TextEntry::make('availability_status')
                            ->label('Availability')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'available' => 'success',
                                'busy' => 'warning',
                                'offline' => 'gray',
                                default => 'gray',
                            }),

                        TextEntry::make('profile_status')
                            ->label('Profile Status')
                            ->badge()
                            ->color('warning'),

                        TextEntry::make('verification_status')
                            ->label('Verification Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'verified' => 'success',
                                'unverified' => 'danger',
                                default => 'gray',
                            }),
                    ])->columns(3),

                // ── Section 3: Identity Verification Data ───────────
                Section::make('Identity Verification')
                    ->icon('heroicon-o-identification')
                    ->description('Sensitive data — visible to admin only.')
                    ->schema([
                        TextEntry::make('identity_number')
                            ->label('Identity Number'),

                        ImageEntry::make('identity_image_path')
                            ->label('Identity Document')
                            ->columnSpanFull()
                            ->imageHeight(300)
                            ->getStateUsing(fn (ProfessionalProfile $record) => 
                                $record->identity_image_path 
                                    ? route('admin.identity-document.show', ['path' => $record->identity_image_path])
                                    : null
                            )
                            ->placeholder('No identity document uploaded.'),
                    ])->columns(2),

                // ── Section 4: Contractor Details (conditional) ─────
                Section::make('Contractor Details')
                    ->icon('heroicon-o-building-office')
                    ->description('Additional business information for contractor accounts.')
                    ->schema([
                        TextEntry::make('contractorDetails.business_name')
                            ->label('Business Name'),

                        TextEntry::make('contractorDetails.contractor_type')
                            ->label('Contractor Type'),

                        TextEntry::make('contractorDetails.team_size')
                            ->label('Team Size')
                            ->default('—'),
                    ])
                    ->columns(3)
                    ->visible(fn (ProfessionalProfile $record): bool =>
                        $record->provider_type === 'contractor'
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Account Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('display_name')
                    ->label('Display Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('provider_type')
                    ->label('Provider Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'professional' => 'info',
                        'contractor' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('city.name')
                    ->label('City')
                    ->sortable(),

                TextColumn::make('user.phone')
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'asc') // oldest first (FIFO queue)
            ->filters([
                Tables\Filters\SelectFilter::make('provider_type')
                    ->options([
                        'professional' => 'Professional',
                        'contractor' => 'Contractor',
                    ]),
            ])
            ->recordActions([
                Action::make('viewRequest')
                    ->label('View Request')
                    ->icon('heroicon-m-eye')
                    ->color('primary')
                    ->url(fn (ProfessionalProfile $record): string =>
                        static::getUrl('view', ['record' => $record])
                    ),
            ])
            ->toolbarActions([])
            ->emptyStateHeading('No Pending Requests')
            ->emptyStateDescription('There are no upgrade requests awaiting review.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUpgradeRequests::route('/'),
            'view' => Pages\ViewUpgradeRequest::route('/{record}'),
        ];
    }
}
