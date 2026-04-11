<?php

namespace App\Filament\Resources\VerificationRequestResource\Pages;

use App\Filament\Resources\VerificationRequestResource;
use App\Models\VerificationRequest;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewVerificationRequest extends ViewRecord
{
    protected static string $resource = VerificationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('view_provider')
                ->label('View Provider Account')
                ->icon('heroicon-m-briefcase')
                ->color('gray')
                ->url(fn (VerificationRequest $record) => \App\Filament\Resources\ProfessionalProfileResource::getUrl('view', ['record' => $record->professional_profile_id]))
                ->openUrlInNewTab(),

            \Filament\Actions\Action::make('contact_whatsapp')
                ->label('WhatsApp Applicant')
                ->icon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('success')
                ->url(fn (VerificationRequest $record) =>
                    'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->professionalProfile->whatsapp_number)
                )
                ->openUrlInNewTab()
                ->visible(fn (VerificationRequest $record) => $record->status === 'pending_review'),

            \Filament\Actions\Action::make('approve')
                ->label('Approve Verification')
                ->icon('heroicon-m-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Verification')
                ->modalDescription('Are you sure you want to verify this provider? A verified badge will be displayed on their public profile.')
                ->modalSubmitActionLabel('Yes, Verify')
                ->action(function (VerificationRequest $record) {
                    $record->update([
                        'status' => 'approved',
                        'reviewed_at' => now(),
                        'reviewed_by' => Auth::id(),
                    ]);

                    // Side-effect: update the profile's public-facing status.
                    $record->professionalProfile->update([
                        'verification_status' => 'verified',
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Verification Approved')
                        ->body('The provider is now verified and the badge is active.')
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn (VerificationRequest $record) => $record->status === 'pending_review'),

            \Filament\Actions\Action::make('reject')
                ->label('Reject Verification')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->schema([
                    \Filament\Forms\Components\Textarea::make('admin_notes')
                        ->label('Reason for Rejection')
                        ->required()
                        ->helperText('This reason will be visible to the applicant so they can fix the issues and resubmit.'),
                ])
                ->modalHeading('Reject Verification Request')
                ->modalDescription('Please provide a reason for rejecting this verification request.')
                ->modalSubmitActionLabel('Reject Request')
                ->action(function (VerificationRequest $record, array $data) {
                    $record->update([
                        'status' => 'rejected',
                        'admin_notes' => $data['admin_notes'],
                        'reviewed_at' => now(),
                        'reviewed_by' => Auth::id(),
                    ]);

                    // verification_status stays 'unverified' — no side-effect needed.

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Verification Rejected')
                        ->body('The applicant has been notified with the rejection reason.')
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn (VerificationRequest $record) => $record->status === 'pending_review'),
        ];
    }
}
