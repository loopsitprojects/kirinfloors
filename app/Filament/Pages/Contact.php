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
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class Contact extends Page
{
    protected string $view = 'filament.pages.common.form';
    protected static string | UnitEnum | null $navigationGroup = 'Static Pages';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Phone;
    protected static ?int $navigationSort = 10;

    public ?array $data = [
        'meta_title' => 'Kirin Flooring | Premium SPC & Click-Lock Flooring',
        'meta_description' => 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.',
        'meta_keywords' => 'flooring, SPC, click-lock, installation, Kirin',
        'custom_meta_tags' => [],
        'breadcrumb_title' => 'Contact Us',
        'contact_text' => 'Have a question about our services or want to get started on your design project? We are here to help! Fill out the contact form below and one of our team members will get back to you within 24 hours. Alternatively, you can reach out to us via phone or email using the contact information provided below. We can\'t wait to hear from you!',
        'email' => 'kirinfloors@sais.lk',
        'phone' => '+94 (TBC)',
        'address' => 'No. 752/1, Dr. Danister De Silva Mawatha, Colombo 09, Sri Lanka',
        'social_facebook' => '#',
        'social_instagram' => '#',
        'social_linkedin' => '#',
        'social_skype' => '#',
    ];

    public function mount(): void
    {
        $this->form->fill($this->loadData());
    }

    protected function loadData(): array
    {
        // Load from storage or database
        if (Storage::exists('contact-content.json')) {
            return json_decode(Storage::get('contact-content.json'), true);
        }

        return [];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        Storage::put('contact-content.json', json_encode($data, JSON_PRETTY_PRINT));

        \Filament\Notifications\Notification::make()
            ->title('Contact page content saved successfully')
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

                            Tab::make('Contact Section')
                                ->schema([
                                    Textarea::make('contact_text')
                                        ->label('Contact Text')
                                        ->rows(4)
                                        ->required(),
                                ]),

                            Tab::make('Contact Info')
                                ->schema([
                                    TextInput::make('email')
                                        ->label('Email')
                                        ->email()
                                        ->required(),
                                    TextInput::make('phone')
                                        ->label('Phone')
                                        ->required(),
                                    Textarea::make('address')
                                        ->label('Address')
                                        ->rows(2)
                                        ->required(),
                                    TextInput::make('social_facebook')
                                        ->label('Facebook URL'),
                                    TextInput::make('social_instagram')
                                        ->label('Instagram URL'),
                                    TextInput::make('social_linkedin')
                                        ->label('LinkedIn URL'),
                                    TextInput::make('social_skype')
                                        ->label('Skype URL'),
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
