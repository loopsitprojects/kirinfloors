<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category')
                    ->default('News')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('The slug is used in the URL for the blog post. It should be unique and can only contain letters, numbers, and hyphens.')
                    ->regex('/^[a-zA-Z0-9-]+$/'),
                TextInput::make('short_description')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->required()
                    ->disk('public')
                    ->directory('blog_images')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('blog_post_images')
                    ->required()
                    ->json()
                    ->columnSpanFull(),
                Section::make('Meta Data')
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('meta_data.meta_title')
                            ->label('Meta Title')
                            ->default('Kirin Flooring | Premium SPC & Click-Lock Flooring')
                            ->required(),
                        Textarea::make('meta_data.meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->default('Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.')
                            ->required(),
                        TextInput::make('meta_data.meta_keywords')
                            ->label('Meta Keywords')
                            ->default('flooring, SPC, click-lock, installation, Kirin')
                            ->required(),
                        Repeater::make('meta_data.custom_meta_tags')
                            ->label('Custom Meta Tags')
                            ->schema([
                                Select::make('attribute')
                                    ->options([
                                        'name' => 'name',
                                        'property' => 'property',
                                    ])
                                    ->default('name')
                                    ->required(),
                                TextInput::make('key')
                                    ->label('Key')
                                    ->placeholder('og:title, twitter:card, etc.')
                                    ->required(),
                                TextInput::make('content')
                                    ->label('Content')
                                    ->required(),
                            ])
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => ($state['attribute'] ?? 'name') . '="' . ($state['key'] ?? '') . '"')
                            ->addActionLabel('Add Meta Tag'),
                    ])
            ]);
    }
}
