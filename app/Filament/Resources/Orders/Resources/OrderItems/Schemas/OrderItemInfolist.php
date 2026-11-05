<?php

namespace App\Filament\Resources\Orders\Resources\OrderItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('order_id')
                //     ->numeric(),
                TextEntry::make('product.name'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('price')
                    ->money('Rs.'),
                TextEntry::make('total')
                    ->money('Rs.')
                    ->getStateUsing(fn ($record) => $record->quantity * $record->price),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
