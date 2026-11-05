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
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('address'),
                TextEntry::make('address_line_2')
                    ->placeholder('-'),
                TextEntry::make('city'),
                // TextEntry::make('state')
                //     ->placeholder('-'),
                TextEntry::make('zip'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
