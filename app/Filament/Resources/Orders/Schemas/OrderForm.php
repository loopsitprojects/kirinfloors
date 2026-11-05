<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('status')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->label('Contact number')
                    ->tel(),
                TextInput::make('whatsapp')
                    ->label('WhatsApp number')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('city')
                    ->required(),
                Select::make('property_type')
                    ->options([
                        'House' => 'House',
                        'Commercial property' => 'Commercial property',
                    ]),
            ]);
    }
}
