<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-star';

    protected static string | \UnitEnum | null $navigationGroup = 'التفاعلات';

    protected static ?string $navigationLabel = 'التقييمات';

    protected static ?string $modelLabel = 'تقييم';

    protected static ?string $pluralModelLabel = 'التقييمات';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('user.name')
                    ->label('Reviewer Name')
                    ->disabled(),

                TextInput::make('professionalProfile.display_name')
                    ->label('Professional Profile')
                    ->disabled(),

                TextInput::make('rating')
                    ->label('Rating (Stars)')
                    ->disabled()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),

                TextInput::make('created_at')
                    ->label('Created At')
                    ->disabled()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('M d, Y H:i')),

                Textarea::make('comment')
                    ->label('Full Comment')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Reviewer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('professionalProfile.display_name')
                    ->label('Professional')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment Preview')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('rating')
                    ->options([
                        '1' => '1 Star',
                        '2' => '2 Stars',
                        '3' => '3 Stars',
                        '4' => '4 Stars',
                        '5' => '5 Stars',
                    ]),

                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')->label('Created From'),
                        DatePicker::make('created_until')->label('Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => Pages\ListReviews::route('/'),
            'view' => Pages\ViewReview::route('/{record}'),
        ];
    }
}
