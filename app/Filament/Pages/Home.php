<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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

class Home extends Page
{
    // implements HasForms
    // use InteractsWithForms;

    protected string $view = 'filament.pages.common.form';
    protected static string | UnitEnum | null $navigationGroup = 'Static Pages';
    protected static ?string $navigationLabel = 'Home Page';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Home;

    public ?array $data = [
        'about_description' => '',
        'services_description' => '',
        'team_description' => '',
        'footer_description' => '',
        'footer_address' => '',
        'process_description' => '',
        'process_background' => '',
        'about_image' => '',
        'mission_content' => '',
        'vision_content' => '',
        'history_content' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_keywords' => '',
        'canonical_url' => '',
        'robots' => '',
        'custom_meta_tags' => [],
        'sponsors' => [],
    ];

    public function mount(): void
    {
        // dd($this->form);
        // $this->data = $this->loadData();
        $this->form->fill($this->loadData());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Form::make([
                    Tabs::make('Content')
                        ->tabs([
                            Tab::make('Hero Section')
                                ->schema([
                                    Repeater::make('hero_slides')
                                        ->schema([
                                            FileUpload::make('image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Background Image')
                                                ->image()
                                                ->directory('hero-slides')
                                                ->required(),
                                            TextInput::make('subtitle')
                                                ->label('Subtitle')
                                                ->required(),
                                            TextInput::make('title')
                                                ->label('Title')
                                                ->required(),
                                            Textarea::make('description')
                                                ->label('Description')
                                                ->rows(3)
                                                ->required(),
                                            TextInput::make('button_text')
                                                ->label('Button Text')
                                                ->default('Our Services'),
                                            TextInput::make('button_link')
                                                ->label('Button Link')
                                                ->default('services.html'),
                                        ])
                                        ->defaultItems(3)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('Services Section')
                                ->schema([
                                    TextInput::make('services_title')
                                        ->label('Section Title')
                                        ->default('Flooring Installation for Homes and Businesses')
                                        ->required(),
                                    Textarea::make('services_description')
                                        ->label('Section Description')
                                        ->rows(3)
                                        ->required(),
                                    Repeater::make('services')
                                        ->schema([
                                            FileUpload::make('image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Service Image')
                                                ->image()
                                                ->directory('services')
                                                ->required(),
                                            TextInput::make('label')
                                                ->label('Service Label')
                                                ->required(),
                                            TextInput::make('title')
                                                ->label('Service Title')
                                                ->required(),
                                        ])
                                        ->defaultItems(4)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('About Section')
                                ->schema([
                                    TextInput::make('about_title')
                                        ->label('Section Title')
                                        ->default('Decades of Expertise in Quality Flooring')
                                        ->required(),
                                    Textarea::make('about_description')
                                        ->label('Section Description')
                                        ->rows(3)
                                        ->required(),
                                    FileUpload::make('about_image')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->label('About Image')
                                        ->image()
                                        ->directory('about')
                                        ->required(),
                                    Section::make('History')
                                        ->schema([
                                            RichEditor::make('history_content')
                                                ->label('History Content')
                                                ->required(),
                                        ]),
                                    Section::make('Mission')
                                        ->schema([
                                            RichEditor::make('mission_content')
                                                ->label('Mission Content')
                                                ->required(),
                                        ]),
                                    Section::make('Vision')
                                        ->schema([
                                            RichEditor::make('vision_content')
                                                ->label('Vision Content')
                                                ->required(),
                                        ]),
                                ]),

                            Tab::make('Process Section')
                                ->schema([
                                    TextInput::make('process_title')
                                        ->label('Section Title')
                                        ->default('From consultation to perfection, every time')
                                        ->required(),
                                    Textarea::make('process_description')
                                        ->label('Section Description')
                                        ->rows(3)
                                        ->required(),
                                    FileUpload::make('process_background')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->label('Background Image')
                                        ->image()
                                        ->directory('process'),
                                    Repeater::make('process_steps')
                                        ->schema([
                                            FileUpload::make('icon')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Step Icon')
                                                ->image()
                                                ->directory('process-icons')
                                                ->required(),
                                            TextInput::make('title')
                                                ->label('Step Title')
                                                ->required(),
                                            Textarea::make('description')
                                                ->label('Step Description')
                                                ->rows(3)
                                                ->required(),
                                        ])
                                        ->defaultItems(4)
                                        ->minItems(1)
                                        ->maxItems(4)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('Testimonials')
                                ->schema([
                                    TextInput::make('testimonials_title')
                                        ->label('Section Title')
                                        ->default('Real Customers, Real Reviews, Real Quality')
                                        ->required(),
                                    Repeater::make('testimonials')
                                        ->schema([
                                            Textarea::make('quote')
                                                ->label('Testimonial Quote')
                                                ->rows(4)
                                                ->required(),
                                            TextInput::make('author_name')
                                                ->label('Author Name')
                                                ->required(),
                                            TextInput::make('author_position')
                                                ->label('Author Position/Title')
                                                ->required(),
                                        ])
                                        ->defaultItems(2)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['author_name'] ?? null),
                                ]),

                            Tab::make('Team Section')
                                ->schema([
                                    TextInput::make('team_title')
                                        ->label('Section Title')
                                        ->default('Meet our skilled team of flooring experts')
                                        ->required(),
                                    Textarea::make('team_description')
                                        ->label('Section Description')
                                        ->rows(2)
                                        ->required(),
                                    Repeater::make('team_members')
                                        ->schema([
                                            FileUpload::make('image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Member Photo')
                                                ->image()
                                                ->directory('team')
                                                ->required(),
                                            TextInput::make('name')
                                                ->label('Name')
                                                ->required(),
                                            TextInput::make('position')
                                                ->label('Position')
                                                ->required(),
                                        ])
                                        ->defaultItems(4)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                                ]),

                            Tab::make('Sponsors Section')
                                ->schema([
                                    TextInput::make('sponsors_title')
                                        ->label('Section Title')
                                        ->default('Our Sponsors')
                                        ->required(),
                                    Textarea::make('sponsors_description')
                                        ->label('Section Description')
                                        ->rows(2)
                                        ->required(),
                                    Repeater::make('sponsors')
                                        ->schema([
                                            FileUpload::make('logo')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Sponsor Logo')
                                                ->image()
                                                ->directory('sponsors')
                                                ->required(),
                                            TextInput::make('alt')
                                                ->label('Alt Text')
                                                ->required(),
                                        ])
                                        ->defaultItems(5)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['alt'] ?? null),
                                ]),

                            Tab::make('Projects Section')
                                ->schema([
                                    TextInput::make('projects_title')
                                        ->label('Section Title')
                                        ->default('Real flooring projects, real customer satisfaction')
                                        ->required(),
                                    Textarea::make('projects_description')
                                        ->label('Section Description')
                                        ->rows(3)
                                        ->required(),
                                    Repeater::make('projects')
                                        ->schema([
                                            FileUpload::make('image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Project Image')
                                                ->image()
                                                ->directory('projects')
                                                ->required(),
                                            TextInput::make('title')
                                                ->label('Project Title')
                                                ->required(),
                                            TextInput::make('link')
                                                ->label('Project Link')
                                                ->default('project-details.html'),
                                        ])
                                        ->defaultItems(5)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('Gallery Section')
                                ->schema([
                                    Repeater::make('gallery')
                                        ->schema([
                                            FileUpload::make('image')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->label('Gallery Image')
                                                ->image()
                                                ->directory('gallery')
                                                ->required(),
                                            TextInput::make('alt')
                                                ->label('Alt Text')
                                                ->required(),
                                        ])
                                        ->defaultItems(6)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['alt'] ?? null),
                                ]),

                            Tab::make('Latest News Section')
                                ->schema([
                                    TextInput::make('latest_news_title')
                                        ->label('Section Title')
                                        ->default('Fresh flooring news, insights, and updates')
                                        ->required(),
                                    Textarea::make('latest_news_description')
                                        ->label('Section Description')
                                        ->rows(3)
                                        ->required(),
                                    Repeater::make('latest_news')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('News Title')
                                                ->required(),
                                            Textarea::make('content')
                                                ->label('News Content')
                                                ->rows(3)
                                                ->required(),
                                            TextInput::make('link')
                                                ->label('Read More Link')
                                                ->default('blog-details.html'),
                                        ])
                                        ->defaultItems(4)
                                        ->minItems(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ]),

                            Tab::make('Footer')
                                ->schema([
                                    TextInput::make('footer_title')
                                        ->label('Footer Title')
                                        ->default('Transform Your Space')
                                        ->required(),
                                    Textarea::make('footer_description')
                                        ->label('Footer Description')
                                        ->rows(3)
                                        ->required(),
                                    TextInput::make('footer_phone')
                                        ->label('Phone Number')
                                        ->tel()
                                        ->required(),
                                    TextInput::make('footer_email')
                                        ->label('Email Address')
                                        ->email()
                                        ->required(),
                                    Textarea::make('footer_address')
                                        ->label('Physical Address')
                                        ->rows(2)
                                        ->required(),
                                    // Section::make('Social Media')
                                    //     ->schema([
                                    //         TextInput::make('social_facebook')
                                    //             ->label('Facebook URL')
                                    //             ->url(),
                                    //         TextInput::make('social_instagram')
                                    //             ->label('Instagram URL')
                                    //             ->url(),
                                    //         TextInput::make('social_youtube')
                                    //             ->label('YouTube URL')
                                    //             ->url(),
                                    //         TextInput::make('social_tiktok')
                                    //             ->label('TikTok URL')
                                    //             ->url(),
                                    //         TextInput::make('social_linkedin')
                                    //             ->label('LinkedIn URL')
                                    //             ->url(),
                                    //     ]),
                                ]),

                            Tab::make('SEO / Meta Tags')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('Meta Title')
                                        ->default('Kirin Flooring | Premium SPC & Click-Lock Flooring')
                                        ->required(),
                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->rows(3)
                                        ->default('Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.')
                                        ->required(),
                                    TextInput::make('meta_keywords')
                                        ->label('Meta Keywords')
                                        ->default('flooring, SPC, click-lock, installation, Kirin')
                                        ->required(),
                                    // TextInput::make('canonical_url')
                                    //     ->label('Canonical URL')
                                    //     ->url()
                                    //     ->placeholder('https://example.com'),
                                    // TextInput::make('robots')
                                    //     ->label('Robots Meta')
                                    //     ->default('index,follow')
                                    //     ->placeholder('index,follow'),
                                    Repeater::make('custom_meta_tags')
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

    public function save(): void
    {
        $data = $this->form->getState();
        // dd($data);
        // Save to storage or database
        // For now, we'll save to storage/app/home-content.json
        Storage::put('home-content.json', json_encode($data, JSON_PRETTY_PRINT));

        \Filament\Notifications\Notification::make()
            ->title('Home page content saved successfully')
            ->success()
            ->send();
    }

    protected function loadData(): array
    {
        // Load from storage or database
        if (Storage::exists('home-content.json')) {
            return json_decode(Storage::get('home-content.json'), true);
        }

        return [];
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Save Changes')
                ->action('save'),
        ];
    }
}
