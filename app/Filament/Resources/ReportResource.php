<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-flag';

    protected static string | \UnitEnum | null $navigationGroup = 'التفاعلات';

    protected static ?string $navigationLabel = 'البلاغات';

    protected static ?string $modelLabel = 'بلاغ';

    protected static ?string $pluralModelLabel = 'البلاغات';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Report Info (Read Only)')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->label('Reporter Name'),

                        TextInput::make('reportable_type')
                            ->label('Report Type')
                            ->disabled()
                            ->formatStateUsing(fn ($state) => match($state) {
                                \App\Models\ProfessionalProfile::class => 'Profile',
                                \App\Models\Review::class => 'Review',
                                \App\Models\PublicRequest::class => 'Request',
                                default => class_basename($state),
                            }),

                        TextEntry::make('reportable_id')
                            ->label('Linked Item Action')
                            ->state(function (?Report $record) {
                                if (!$record || !$record->reportable_id) return '-';
                                return "Item #{$record->reportable_id}";
                            }),
                    ])->columns(3),

                Section::make('Content')
                    ->schema([
                        TextInput::make('reason')
                            ->label('Reason')
                            ->disabled()
                            ->maxLength(255),
                            
                        Textarea::make('description')
                            ->label('Description')
                            ->disabled()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),

                Section::make('Status Update')
                    ->schema([
                        Select::make('status')
                            ->label('Resolution Status')
                            ->options([
                                'pending' => 'Pending',
                                'reviewing' => 'Reviewing',
                                'resolved' => 'Resolved',
                                'rejected' => 'Rejected',
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

                TextColumn::make('user.name')
                    ->label('Reporter')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('reportable_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        \App\Models\ProfessionalProfile::class => 'Profile',
                        \App\Models\Review::class => 'Review',
                        \App\Models\PublicRequest::class => 'Request',
                        default => class_basename($state),
                    })
                    ->sortable(),

                TextColumn::make('reason')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'reviewing' => 'warning',
                        'resolved' => 'success',
                        'rejected' => 'gray',
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
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'resolved' => 'Resolved',
                        'rejected' => 'Rejected',
                    ]),
                    
                SelectFilter::make('reportable_type')
                    ->label('Type')
                    ->options([
                        \App\Models\ProfessionalProfile::class => 'Profile',
                        \App\Models\Review::class => 'Review',
                        \App\Models\PublicRequest::class => 'Request',
                    ]),
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
            'index' => Pages\ListReports::route('/'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
