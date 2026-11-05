<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class AboutUs extends Page
{
    protected string $view = 'filament.pages.common.form';
    protected static string | UnitEnum | null $navigationGroup = 'Static Pages';
    protected static ?string $navigationLabel = 'About Us Page';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::InformationCircle;
    protected static ?int $navigationSort = 10;

    public ?array $data = [
        'breadcrumb_title' => 'About Us',
        // 'off_canvas_text' => 'Welcome to Florix, A Full Service of Flooring and Tilling Works.',
        'about_description' => '<p>At <b>Kirin SPC Flooring</b>, we are passionate about transforming spaces with high-quality flooring solutions that blend style, durability, and functionality. With over a decade of experience, our team specializes in a wide range of flooring services, including hardwood, laminate, vinyl, and tile installations for both residential and commercial properties.</p><p>We take pride in our attention to detail, from helping you select the perfect materials to ensuring expert installation and long-lasting results. Whether you’re looking to renovate a single room or update your entire property, Kirin SPC Flooring is dedicated to delivering top-notch service, on-time project completion, and complete customer satisfaction.</p><p>From custom designs to flooring repairs and refinishing, Kirin SPC Flooring is your trusted partner in creating beautiful, durable floors that enhance the value of your home or business.</p>',
        'about_image' => '',
        'timeline' => [],
        'about_more_heading' => 'Elevate your home’s aesthetic with floors that blend elegance, durability, and modern design—crafted to last and transform every space beautifully.',
        'about_more_image' => '',
        'about_more_content' => '<p>At <b>Kirin SPC Flooring</b>, our mission is to deliver exceptional flooring solutions tailored to our clients’ unique needs and styles. We are committed to providing high-quality materials and expert installation services while fostering a seamless and enjoyable customer experience. Through integrity, innovation, and a dedication to craftsmanship, we strive to enhance every space we touch, ensuring durability and beauty in every project. Our goal is to build lasting relationships with our clients, contributing to the transformation of their environments with flooring that inspires.</p><p>We aim to set the standard for excellence in craftsmanship and customer service while promoting environmentally responsible practices in every project we undertake.</p>',
        'counter_since' => '1995',
        'counter_offices' => '16',
        'counter_projects' => '215',
        'counter_countries' => '47',
        'gallery_title' => 'Showcase',
        'gallery_description' => 'Flooring Installation for Homes and Businesses',
        'gallery' => [],
        'team_title' => 'Meet our skilled team of flooring experts',
        'team_description' => 'We provide professional flooring installation, repair, refinishing, maintenance, and custom design services for homes and businesses.',
        'team_members' => [],
        'meta_title' => 'Kirin Flooring | Premium SPC & Click-Lock Flooring',
        'meta_description' => 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.',
        'meta_keywords' => 'flooring, SPC, click-lock, installation, Kirin',
        'custom_meta_tags' => [],
    ];

    public function mount(): void
    {
        // dd($this->form);
        // $this->data = $this->loadData();
        $this->form->fill($this->loadData());
    }


    public function save(): void
    {
        $data = $this->form->getState();
        // dd($data);
        // Save to storage or database
        // For now, we'll save to storage/app/about-content.json
        Storage::put('about-content.json', json_encode($data, JSON_PRETTY_PRINT));

        \Filament\Notifications\Notification::make()
            ->title('About Us page content saved successfully')
            ->success()
            ->send();
    }

    protected function loadData(): array
    {
        // Load from storage or database
        if (Storage::exists('about-content.json')) {
            return json_decode(Storage::get('about-content.json'), true);
        }

        return [];
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
                                        ->label('Breadcrumb Title')
                                        ->default('About Us'),
                                    FileUpload::make('breadcrumb_image')->disk('public')->directory('breadcrumb')->image(),
                                ]),

                            // Tab::make('Off-canvas')
                            //     ->schema([
                            //         Textarea::make('off_canvas_text')
                            //             ->label('Off-canvas Text')
                            //             ->default('Welcome to Florix, A Full Service of Flooring and Tilling Works.'),
                            //     ]),

                            Tab::make('About Section')
                                ->schema([
                                    RichEditor::make('about_description')
                                        ->label('About Description')
                                        ->default('<p>At <b>Kirin SPC Flooring</b>, we are passionate about transforming spaces with high-quality flooring solutions that blend style, durability, and functionality. With over a decade of experience, our team specializes in a wide range of flooring services, including hardwood, laminate, vinyl, and tile installations for both residential and commercial properties.</p><p>We take pride in our attention to detail, from helping you select the perfect materials to ensuring expert installation and long-lasting results. Whether you’re looking to renovate a single room or update your entire property, Kirin SPC Flooring is dedicated to delivering top-notch service, on-time project completion, and complete customer satisfaction.</p><p>From custom designs to flooring repairs and refinishing, Kirin SPC Flooring is your trusted partner in creating beautiful, durable floors that enhance the value of your home or business.</p>'),
                                    FileUpload::make('about_image')
                                        ->disk('public')
                                        ->directory('about')
                                        ->image()
                                        ->label('About Image'),
                                ]),

                            Tab::make('Timeline')
                                ->schema([
                                    Repeater::make('timeline')
                                        ->schema([
                                            TextInput::make('date'),
                                            TextInput::make('title'),
                                            Textarea::make('text'),
                                            FileUpload::make('image')->disk('public')->directory('timeline')->image(),
                                        ])
                                        ->defaultItems(5)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('About More')
                                ->schema([
                                    TextInput::make('about_more_heading')
                                        ->label('Heading')
                                        ->default('Elevate your home’s aesthetic with floors that blend elegance, durability, and modern design—crafted to last and transform every space beautifully.'),
                                    FileUpload::make('about_more_image')
                                        ->disk('public')
                                        ->directory('about')
                                        ->image()
                                        ->label('Image'),
                                    RichEditor::make('about_more_content')
                                        ->label('Content')
                                        ->default('<p>At <b>Kirin SPC Flooring</b>, our mission is to deliver exceptional flooring solutions tailored to our clients’ unique needs and styles. We are committed to providing high-quality materials and expert installation services while fostering a seamless and enjoyable customer experience. Through integrity, innovation, and a dedication to craftsmanship, we strive to enhance every space we touch, ensuring durability and beauty in every project. Our goal is to build lasting relationships with our clients, contributing to the transformation of their environments with flooring that inspires.</p><p>We aim to set the standard for excellence in craftsmanship and customer service while promoting environmentally responsible practices in every project we undertake.</p>'),
                                ]),
                            Tab::make('History Section')
                                ->schema([
                                    RichEditor::make('history_description')
                                        ->label('History Description')
                                        ->default('<p>At <b>Kirin SPC Flooring</b>, we are passionate about transforming spaces with high-quality flooring solutions that blend style, durability, and functionality. With over a decade of experience, our team specializes in a wide range of flooring services, including hardwood, laminate, vinyl, and tile installations for both residential and commercial properties.</p><p>We take pride in our attention to detail, from helping you select the perfect materials to ensuring expert installation and long-lasting results. Whether you’re looking to renovate a single room or update your entire property, Kirin SPC Flooring is dedicated to delivering top-notch service, on-time project completion, and complete customer satisfaction.</p><p>From custom designs to flooring repairs and refinishing, Kirin SPC Flooring is your trusted partner in creating beautiful, durable floors that enhance the value of your home or business.</p>'),
                                    FileUpload::make('history_image')
                                        ->disk('public')
                                        ->directory('about')
                                        ->image()
                                        ->label('History Image'),
                                ]),

                            Tab::make('Counter')
                                ->schema([
                                    TextInput::make('counter_since')->label('Since Year')->default('1995'),
                                    TextInput::make('counter_offices')->label('Offices')->default('16'),
                                    TextInput::make('counter_projects')->label('Projects')->default('215'),
                                    TextInput::make('counter_countries')->label('Countries')->default('47'),
                                ]),

                            Tab::make('Gallery')
                                ->schema([
                                    TextInput::make('gallery_title')->label('Title')->default('Showcase'),
                                    Textarea::make('gallery_description')->label('Description')->default('Flooring Installation for Homes and Businesses'),
                                    Repeater::make('gallery')
                                        ->schema([
                                            FileUpload::make('image')->disk('public')->directory('gallery')->image(),
                                            TextInput::make('alt'),
                                        ])
                                        ->defaultItems(6)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['alt'] ?? null),
                                ]),

                            Tab::make('Team')
                                ->schema([
                                    TextInput::make('team_title')->label('Title')->default('Meet our skilled team of flooring experts'),
                                    Textarea::make('team_description')->label('Description')->default('We provide professional flooring installation, repair, refinishing, maintenance, and custom design services for homes and businesses.'),
                                    Repeater::make('team_members')
                                        ->schema([
                                            TextInput::make('name'),
                                            TextInput::make('position'),
                                            FileUpload::make('image')->disk('public')->directory('team')->image(),
                                        ])
                                        ->defaultItems(4)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                                ]),

                            Tab::make('SEO / Meta Tags')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('Meta Title')
                                        ->default('Kirin Flooring | Premium SPC & Click-Lock Flooring'),
                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->rows(3)
                                        ->default('Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.'),
                                    TextInput::make('meta_keywords')
                                        ->label('Meta Keywords')
                                        ->default('flooring, SPC, click-lock, installation, Kirin'),
                                    Repeater::make('custom_meta_tags')
                                        ->label('Custom Meta Tags')
                                        ->schema([
                                            Select::make('attribute')
                                                ->options([
                                                    'name' => 'name',
                                                    'property' => 'property',
                                                    'http-equiv' => 'http-equiv',
                                                ])
                                                ->default('name'),
                                            TextInput::make('key'),
                                            TextInput::make('content'),
                                        ])
                                        ->defaultItems(0)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => ($state['attribute'] ?? 'name') . '="' . ($state['key'] ?? '') . '"'),
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
