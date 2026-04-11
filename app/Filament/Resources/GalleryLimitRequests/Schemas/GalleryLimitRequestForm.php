<?php

namespace App\Filament\Resources\GalleryLimitRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class GalleryLimitRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الطلب')
                    ->description('مراجعة طلب زيادة سعة المعرض')
                    ->schema([
                        Placeholder::make('ملاحظة هامة جداً')
                            ->content('الموافقة على هذا الطلب هنا هي للمتابعة الإدارية فقط ولن تقوم بزيادة سعة المعرض تلقائياً. لزيادة السعة فعلياً، يجب عليك الذهاب إلى ملف الحرفي وتحديث حقل (Gallery Limit Override) يدوياً.')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'text-red-500 font-bold bg-red-50 p-4 rounded-xl border border-red-200 block']),
                            
                        Select::make('professional_profile_id')
                            ->label('الملف المهني')
                            ->relationship('professionalProfile', 'display_name')
                            ->disabled()
                            ->required(),
                            
                        TextInput::make('requested_limit')
                            ->label('السعة المطلوبة (عدد الصور)')
                            ->disabled()
                            ->numeric(),
                            
                        FileUpload::make('payment_proof_path')
                            ->label('سند التحويل (مرفق)')
                            ->disk('local')
                            ->directory('payment-proofs')
                            ->openable()
                            ->downloadable()
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('قرار الإدارة')
                    ->schema([
                        Select::make('status')
                            ->label('حالة الطلب')
                            ->options([
                                'pending_review' => 'قيد المراجعة',
                                'approved' => 'مقبول',
                                'rejected' => 'مرفوض',
                            ])
                            ->required()
                            ->default('pending_review'),
                            
                        Textarea::make('admin_notes')
                            ->label('ملاحظات الإدارة (اختياري)')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
