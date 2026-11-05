<?php

namespace App\Filament\Resources\ContactEnquiries;

use App\Filament\Resources\ContactEnquiries\Pages\ListContactEnquiries;
use App\Mail\ContactFormMail;
use App\Models\ContactEnquiry;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactEnquiryResource extends Resource
{
    protected static ?string $model = ContactEnquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('message')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('emailed_at')
                    ->label('Emailed')
                    ->dateTime()
                    ->placeholder('Not sent'),
            ])
            ->recordActions([
                Action::make('sendEmail')
                    ->label(fn (ContactEnquiry $record): string => $record->emailed_at ? 'Resend' : 'Send email')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->requiresConfirmation()
                    ->modalHeading(fn (ContactEnquiry $record): string => $record->emailed_at ? 'Resend this enquiry?' : 'Send this enquiry?')
                    ->modalDescription(fn (): string => 'It will be emailed to '.(config('services.contact_email') ?: '(no CONTACT_EMAIL set)').'.')
                    ->modalSubmitActionLabel('Send')
                    ->action(fn (ContactEnquiry $record) => static::sendEmail($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function sendEmail(ContactEnquiry $enquiry): void
    {
        $recipient = config('services.contact_email');

        if (blank($recipient)) {
            Notification::make()
                ->title('Not sent: CONTACT_EMAIL is not set')
                ->danger()
                ->send();

            return;
        }

        try {
            Mail::to($recipient)->send(new ContactFormMail($enquiry->only(['name', 'email', 'phone', 'message'])));
        } catch (Throwable $e) {
            report($e);

            Notification::make()
                ->title('Email could not be sent')
                ->body('The enquiry is still saved here. Please check the mail settings and try again.')
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        $enquiry->update(['emailed_at' => now()]);

        Notification::make()
            ->title("Enquiry emailed to {$recipient}")
            ->success()
            ->send();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactEnquiries::route('/'),
        ];
    }
}
