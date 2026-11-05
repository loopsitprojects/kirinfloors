<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class Services extends Page
{
    protected string $view = 'filament.pages.common.form';
    protected static string | UnitEnum | null $navigationGroup = 'Static Pages';
    protected static ?string $navigationLabel = 'Services';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::AcademicCap;
    protected static ?int $navigationSort = 10;

    public ?array $data = [
        'meta_title' => 'Kirin Flooring | Premium SPC & Click-Lock Flooring',
        'meta_description' => 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.',
        'meta_keywords' => 'flooring, SPC, click-lock, installation, Kirin',
        'custom_meta_tags' => [],
        'breadcrumb_title' => 'Our Services',
        'service_title' => 'Flooring Installation for Homes and Businesses',
        'service_description' => 'We provide professional flooring installation, repair, refinishing, maintenance, and custom design services for homes and businesses.',
        'services' => [],
        'accordion_items' => [],
        'testimonials_title' => 'Real Customers, Real Reviews, Real Quality!',
        'testimonials_description' => 'Concept design involves creating a foundational framework that guides the development of a project.',
        'testimonials' => [],
        'footer_title' => 'Transform Your Space',
        'footer_description' => 'You\'re invited to explore our innovative flooring solutions, featuring durable, water-resistant vinyl planks and engineered wood, perfect for enhancing the beauty of your space!',
        'footer_phone' => '+34 567 721 12 35',
        'footer_email' => 'info@florix.com',
        'footer_address' => '77 Kennedy Road Soho Manhattan New York - USA',
        'footer_copyright' => 'Copyright © 2025 Kirin. - All rights reserved.',
    ];

    public function mount(): void
    {
        $this->form->fill($this->loadData());
    }

    protected function loadData(): array
    {
        // Load from storage or database
        if (Storage::exists('services-content.json')) {
            return json_decode(Storage::get('services-content.json'), true);
        }

        return [];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        Storage::put('services-content.json', json_encode($data, JSON_PRETTY_PRINT));

        \Filament\Notifications\Notification::make()
            ->title('Services page content saved successfully')
            ->success()
            ->send();
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Form::make([
                    Tabs::make('Content')
                        ->tabs([
                            Tab::make('Breadcrumb')
                                ->schema([
                                    TextInput::make('breadcrumb_title')
                                        ->label('Breadcrumb Title'),
                                    FileUpload::make('breadcrumb_image')->disk('public')->directory('breadcrumb')->image(),
                                ]),

                            Tab::make('Service Section')
                                ->schema([
                                    TextInput::make('service_title')
                                        ->label('Section Title')
                                        ->required(),
                                    Textarea::make('service_description')
                                        ->label('Section Description')
                                        ->rows(3)
                                        ->required(),
                                    FileUpload::make('service_main_image')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->label('Main Service Image')
                                        ->image()
                                        ->directory('services'),
                                    Repeater::make('services')
                                        ->schema([
                                            FileUpload::make('image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->image()
                                                ->directory('services'),
                                            TextInput::make('category')
                                                ->label('Category'),
                                            TextInput::make('title')
                                                ->label('Title'),
                                        ])
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                    FileUpload::make('service_side_image')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->label('Side Service Image')
                                        ->image()
                                        ->directory('services'),
                                    Repeater::make('accordion_items')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Accordion Title')
                                                ->required(),
                                            Textarea::make('content')
                                                ->label('Content')
                                                ->rows(4)
                                                ->required(),
                                        ])
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('Testimonials')
                                ->schema([
                                    TextInput::make('testimonials_title')
                                        ->label('Section Title')
                                        ->required(),
                                    Textarea::make('testimonials_description')
                                        ->label('Description')
                                        ->rows(2)
                                        ->required(),
                                    Repeater::make('testimonials')
                                        ->schema([
                                            Textarea::make('quote')
                                                ->label('Quote')
                                                ->rows(4)
                                                ->required(),
                                            TextInput::make('author_name')
                                                ->label('Author Name')
                                                ->required(),
                                            TextInput::make('author_position')
                                                ->label('Author Position')
                                                ->required(),
                                            FileUpload::make('author_image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->image()
                                                ->directory('testimonials'),
                                        ])
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['author_name'] ?? null),
                                ]),
                            Tab::make('SEO / Meta Tags')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('Meta Title'),
                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->rows(3),
                                    TextInput::make('meta_keywords')
                                        ->label('Meta Keywords'),
                                    Repeater::make('custom_meta_tags')
                                        ->label('Custom Meta Tags')
                                        ->schema([
                                            Select::make('attribute')
                                                ->options([
                                                    'name' => 'name',
                                                    'property' => 'property',
                                                ])
                                                ->required(),
                                            TextInput::make('key')->required(),
                                            TextInput::make('content')->required(),
                                        ])
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => ($state['attribute'] ?? 'name') . '="' . ($state['key'] ?? '') . '"')
                                        ->addActionLabel('Add Meta Tag'),
                                ]),
                        ])
                        ->vertical()
                        ->columnSpanFull(),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save Changes')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ])
                    ])
            ])
            ->statePath('data');
    }
}
