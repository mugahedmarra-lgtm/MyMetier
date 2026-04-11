<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerificationRequestResource\Pages;
use App\Models\VerificationRequest;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VerificationRequestResource extends Resource
{
    protected static ?string $model = VerificationRequest::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected static string | \UnitEnum | null $navigationGroup = 'المهنيين';

    protected static ?string $navigationLabel = 'طلبات التوثيق';

    protected static ?string $modelLabel = 'طلب توثيق';

    protected static ?string $pluralModelLabel = 'طلبات التوثيق';

    protected static ?string $slug = 'verification-requests';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    /**
     * Badge showing the count of pending verification requests.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = VerificationRequest::where('status', 'pending_review')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'info';
    }

    /**
     * Base query: only pending_review requests.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'pending_review');
    }

    /**
     * Infolist schema for the review details page.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ── Section 1: Applicant Information ──────────────
                Section::make('Applicant Information')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextEntry::make('professionalProfile.user.name')
                            ->label('Account Name'),

                        TextEntry::make('professionalProfile.display_name')
                            ->label('Display Name'),

                        TextEntry::make('professionalProfile.user.phone')
                            ->label('Primary Phone'),

                        TextEntry::make('professionalProfile.provider_type')
                            ->label('Provider Type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'professional' => 'info',
                                'contractor' => 'success',
                                default => 'gray',
                            }),

                        TextEntry::make('professionalProfile.category.name')
                            ->label('Category'),

                        TextEntry::make('professionalProfile.city.name')
                            ->label('City'),
                    ])->columns(3),

                // ── Section 2: Request Details ───────────────────
                Section::make('Request Details')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Request Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending_review' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('submitted_at')
                            ->label('Submitted At')
                            ->dateTime(),

                        TextEntry::make('reviewed_at')
                            ->label('Reviewed At')
                            ->dateTime()
                            ->placeholder('Not yet reviewed'),

                        TextEntry::make('reviewer.name')
                            ->label('Reviewed By')
                            ->placeholder('—'),
                    ])->columns(2),

                // ── Section 3: Payment Proof ─────────────────────
                Section::make('Payment Proof')
                    ->icon('heroicon-o-currency-dollar')
                    ->description('Bank transfer receipt uploaded by the provider.')
                    ->schema([
                        RepeatableEntry::make('paymentProofDocuments')
                            ->label('')
                            ->getStateUsing(fn (\App\Models\VerificationRequest $record) => 
                                $record->documents->where('document_type', 'payment_proof')->values()
                            )
                            ->schema([
                                TextEntry::make('document_type')
                                    ->label('Document Type')
                                    ->formatStateUsing(fn (string $state): string =>
                                        \App\Models\VerificationDocument::DOCUMENT_TYPES[$state] ?? $state
                                    ),

                                TextEntry::make('original_filename')
                                    ->label('File Name')
                                    ->default('—'),

                                ImageEntry::make('file_path')
                                    ->label('Document Preview')
                                    ->getStateUsing(fn (array|\App\Models\VerificationDocument $record) =>
                                        (is_array($record) ? $record['file_path'] ?? null : $record->file_path)
                                            ? route('admin.verification-document.show', ['path' => (is_array($record) ? $record['file_path'] : $record->file_path)])
                                            : null
                                    )
                                    ->imageHeight(300),
                            ])->columns(3),
                    ])
                    ->visible(fn (\App\Models\VerificationRequest $record) => $record->documents->where('document_type', 'payment_proof')->isNotEmpty()),

                // ── Section 4: Identity & Professional Documents ─
                Section::make('Identity & Professional Documents')
                    ->icon('heroicon-o-paper-clip')
                    ->description('Verification documents containing identity and licenses.')
                    ->schema([
                        RepeatableEntry::make('identityDocuments')
                            ->label('')
                            ->getStateUsing(fn (\App\Models\VerificationRequest $record) => 
                                $record->documents->where('document_type', '!=', 'payment_proof')->values()
                            )
                            ->schema([
                                TextEntry::make('document_type')
                                    ->label('Document Type')
                                    ->formatStateUsing(fn (string $state): string =>
                                        \App\Models\VerificationDocument::DOCUMENT_TYPES[$state] ?? $state
                                    ),

                                TextEntry::make('original_filename')
                                    ->label('File Name')
                                    ->default('—'),

                                ImageEntry::make('file_path')
                                    ->label('Document Preview')
                                    ->getStateUsing(fn (array|\App\Models\VerificationDocument $record) =>
                                        (is_array($record) ? $record['file_path'] ?? null : $record->file_path)
                                            ? route('admin.verification-document.show', ['path' => (is_array($record) ? $record['file_path'] : $record->file_path)])
                                            : null
                                    )
                                    ->imageHeight(200),
                            ])->columns(3),
                    ]),

                // ── Section 4: Previous Attempts (history) ───────
                Section::make('Previous Attempts')
                    ->icon('heroicon-o-clock')
                    ->description('History of past verification requests for this provider.')
                    ->schema([
                        TextEntry::make('history_summary')
                            ->label('')
                            ->getStateUsing(function (VerificationRequest $record): string {
                                $history = VerificationRequest::where('professional_profile_id', $record->professional_profile_id)
                                    ->where('id', '!=', $record->id)
                                    ->orderByDesc('created_at')
                                    ->get();

                                if ($history->isEmpty()) {
                                    return 'This is the first verification attempt.';
                                }

                                $lines = [];
                                foreach ($history as $past) {
                                    $date = $past->submitted_at?->format('Y-m-d H:i') ?? '—';
                                    $status = ucfirst(str_replace('_', ' ', $past->status));
                                    $note = $past->admin_notes ? " — {$past->admin_notes}" : '';
                                    $lines[] = "• [{$date}] {$status}{$note}";
                                }

                                return implode("\n", $lines);
                            })
                            ->markdown(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('professionalProfile.user.name')
                    ->label('Account Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('professionalProfile.display_name')
                    ->label('Display Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('professionalProfile.provider_type')
                    ->label('Provider Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'professional' => 'info',
                        'contractor' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('professionalProfile.city.name')
                    ->label('City')
                    ->sortable(),

                TextColumn::make('documents_count')
                    ->label('Documents')
                    ->counts('documents')
                    ->sortable(),

                TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('submitted_at', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('provider_type')
                    ->relationship('professionalProfile', 'provider_type')
                    ->options([
                        'professional' => 'Professional',
                        'contractor' => 'Contractor',
                    ]),
            ])
            ->recordActions([
                Action::make('viewRequest')
                    ->label('Review')
                    ->icon('heroicon-m-eye')
                    ->color('primary')
                    ->url(fn (VerificationRequest $record): string =>
                        static::getUrl('view', ['record' => $record])
                    ),
            ])
            ->groupedBulkActions([])
            ->emptyStateHeading('No Pending Verification Requests')
            ->emptyStateDescription('There are no verification requests awaiting review.')
            ->emptyStateIcon('heroicon-o-shield-check')
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerificationRequests::route('/'),
            'view' => Pages\ViewVerificationRequest::route('/{record}'),
        ];
    }
}
