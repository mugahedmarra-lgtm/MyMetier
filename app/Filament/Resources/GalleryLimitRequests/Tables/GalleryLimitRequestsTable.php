<?php

namespace App\Filament\Resources\GalleryLimitRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryLimitRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('professionalProfile.display_name')
                    ->label('الملف المهني')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('requested_limit')
                    ->label('السعة المطلوبة')
                    ->numeric()
                    ->sortable(),
                    
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_review' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_review' => 'قيد المراجعة',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض',
                        default => $state,
                    })
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->label('مراجعة'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
