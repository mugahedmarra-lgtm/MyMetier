<?php

namespace App\Filament\Resources\UpgradeRequestResource\Pages;

use App\Filament\Resources\UpgradeRequestResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUpgradeRequest extends ViewRecord
{
    protected static string $resource = UpgradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('view_provider')
                ->label('View Provider Account')
                ->icon('heroicon-m-briefcase')
                ->color('gray')
                ->url(fn (\App\Models\ProfessionalProfile $record) => \App\Filament\Resources\ProfessionalProfileResource::getUrl('view', ['record' => $record->id]))
                ->openUrlInNewTab(),

            \Filament\Actions\Action::make('contact_whatsapp')
                ->label('WhatsApp Applicant')
                ->icon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('success')
                ->url(fn (\App\Models\ProfessionalProfile $record) => 
                    // Remove any non-numeric characters for reliable WhatsApp links
                    'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->whatsapp_number)
                )
                ->openUrlInNewTab()
                ->visible(fn (\App\Models\ProfessionalProfile $record) => $record->profile_status === 'pending_review'),

            \Filament\Actions\Action::make('approve')
                ->label('Approve Request')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Upgrade Request')
                ->modalDescription('Are you sure you want to approve this applicant? Their professional profile will immediately become active and visible in the platform.')
                ->modalSubmitActionLabel('Yes, Approve')
                ->action(function (\App\Models\ProfessionalProfile $record) {
                    $record->update([
                        'profile_status' => 'active',
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Request Approved')
                        ->body('The professional profile is now active.')
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn (\App\Models\ProfessionalProfile $record) => $record->profile_status === 'pending_review'),

            \Filament\Actions\Action::make('reject')
                ->label('Reject Request')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->schema([
                    \Filament\Forms\Components\Textarea::make('admin_notes')
                        ->label('Reason for Rejection')
                        ->required()
                        ->helperText('This reason will be visible to the applicant so they can fix the issues and resubmit.')
                ])
                ->modalHeading('Reject Upgrade Request')
                ->modalDescription('Please provide a reason for rejecting this request.')
                ->modalSubmitActionLabel('Reject Request')
                ->action(function (\App\Models\ProfessionalProfile $record, array $data) {
                    $record->update([
                        'profile_status' => 'rejected',
                        'admin_notes' => $data['admin_notes'],
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Request Rejected')
                        ->body('The applicant has been rejected with the provided notes.')
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn (\App\Models\ProfessionalProfile $record) => $record->profile_status === 'pending_review'),
        ];
    }
}
