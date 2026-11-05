<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('status'),
                TextEntry::make('name'),
                TextEntry::make('phone')
                    ->label('Contact number')
                    ->placeholder('-'),
                TextEntry::make('whatsapp')
                    ->label('WhatsApp number')
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('city'),
                TextEntry::make('property_type')
                    ->placeholder('-'),
                // Only orders placed before the quote form have these.
                TextEntry::make('address')
                    ->visible(fn ($record) => filled($record->address)),
                TextEntry::make('address_line_2')
                    ->visible(fn ($record) => filled($record->address_line_2)),
                TextEntry::make('zip')
                    ->visible(fn ($record) => filled($record->zip)),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
