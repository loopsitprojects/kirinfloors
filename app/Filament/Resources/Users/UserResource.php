<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 100;

    // Nobody can take away their own access or delete themselves, so the panel can't lock everyone out.
    private static function isMe(?User $record): bool
    {
        return $record !== null && $record->is(auth()->user());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            TextInput::make('password')
                ->password()
                ->revealable()
                ->minLength(12)
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->helperText(fn (string $operation): ?string => $operation === 'edit' ? 'Leave empty to keep the current password.' : 'At least 12 characters.'),
            Toggle::make('is_admin')
                ->label('Can access admin')
                ->disabled(fn (?User $record): bool => static::isMe($record))
                ->helperText(fn (?User $record): ?string => static::isMe($record) ? "You can't remove your own access." : null),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                ToggleColumn::make('is_admin')
                    ->label('Can access admin')
                    ->disabled(fn (User $record): bool => static::isMe($record)),
                IconColumn::make('app_authentication_secret')
                    ->label('Authenticator app')
                    ->state(fn (User $record): bool => filled($record->app_authentication_secret))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                // For someone who lost their phone: they sign in with just the password and set it up again.
                Action::make('resetAuthenticator')
                    ->label('Reset authenticator')
                    ->icon(Heroicon::OutlinedDevicePhoneMobile)
                    ->color('warning')
                    ->visible(fn (User $record): bool => filled($record->app_authentication_secret) && ! static::isMe($record))
                    ->requiresConfirmation()
                    ->modalDescription('They will sign in with just their password until they set up the authenticator app again.')
                    ->action(function (User $record): void {
                        $record->saveAppAuthenticationSecret(null);
                        $record->saveAppAuthenticationRecoveryCodes(null);

                        Notification::make()->title('Authenticator app reset')->success()->send();
                    }),
                DeleteAction::make()
                    ->hidden(fn (User $record): bool => static::isMe($record)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
