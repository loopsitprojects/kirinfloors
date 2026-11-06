<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.'),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(0),
                FileUpload::make('image')
                    ->required()
                    ->disk('public')
                    ->directory('products')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->columnSpanFull(),
                Repeater::make('additional_images')
                    ->label('Additional Images')
                    ->schema([
                        FileUpload::make('path')
                            ->disk('public')
                            ->directory('products_additional_images')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->collapsible()
                    // ->itemLabel(fn(array $state): ?string => $state['path'] ?? null)
                    ->addActionLabel('Add Additional Image'),
                Select::make('category')
                    ->required()
                    ->options([
                        'TIMBERLINE' => 'Timberline',
                        'STONEDGE' => 'Stonedge',
                        'ACCESSORIES' => 'Accessories',
                    ]),
                TextInput::make('design_code'),
                TextInput::make('design_grain'),
                TextInput::make('colour_tone'),
                TextInput::make('texture'),
                Textarea::make('application')
                    ->columnSpanFull(),
                TextInput::make('dimensions'),
                TextInput::make('short_description')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                // Textarea::make('meta_details')
                //     ->columnSpanFull(),
            ]);
    }
}
