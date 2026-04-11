<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static string | \UnitEnum | null $navigationGroup = 'إدارة الحسابات';

    protected static ?string $navigationLabel = 'المستخدمين';

    protected static ?string $modelLabel = 'مستخدم';

    protected static ?string $pluralModelLabel = 'المستخدمين';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->revealable(),

                Select::make('role')
                    ->options([
                        'customer' => 'Customer',
                        'professional' => 'Professional',
                        'contractor' => 'Contractor',
                        'admin' => 'Admin',
                    ])
                    ->required()
                    ->default('customer'),

                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                    ])
                    ->required()
                    ->default('active'),

                FileUpload::make('avatar')
                    ->image()
                    ->directory('avatars')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('avatar')
                    ->circular()
                    ->toggleable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'professional' => 'info',
                        'contractor' => 'warning',
                        'customer' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'admin' => 'heroicon-m-shield-check',
                        'professional' => 'heroicon-m-briefcase',
                        'contractor' => 'heroicon-m-building-office',
                        'customer' => 'heroicon-m-user',
                        default => 'heroicon-m-user',
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'suspended' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'customer' => 'Customer',
                        'professional' => 'Professional',
                        'contractor' => 'Contractor',
                        'admin' => 'Admin',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->action(function (User $record) {
                        if ($record->role === 'admin') {
                            Notification::make()
                                ->danger()
                                ->title('Action Denied')
                                ->body('You cannot delete an admin user.')
                                ->send();
                            return;
                        }
                        $record->delete();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $adminExists = false;
                            foreach ($records as $record) {
                                if ($record->role === 'admin') {
                                    $adminExists = true;
                                    continue;
                                }
                                $record->delete();
                            }
                            
                            if ($adminExists) {
                                Notification::make()
                                    ->warning()
                                    ->title('Partial Deletion')
                                    ->body('Admin users cannot be deleted and were safely skipped.')
                                    ->send();
                            } else {
                                Notification::make()
                                    ->success()
                                    ->title('Records Deleted')
                                    ->send();
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProfessionalProfileRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
