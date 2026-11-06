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

class TechnicalData extends Page
{
    protected string $view = 'filament.pages.common.form';
    protected static string | UnitEnum | null $navigationGroup = 'Static Pages';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Camera;
    protected static ?string $navigationLabel = 'Resources';
    protected static ?string $title = 'Resources';
    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->loadData());
    }

    protected function loadData(): array
    {
        // Load from storage or database
        if (Storage::exists('technical-content.json')) {
            return json_decode(Storage::get('technical-content.json'), true);
        }

        return [];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        Storage::put('technical-content.json', json_encode($data, JSON_PRETTY_PRINT));

        \Filament\Notifications\Notification::make()
            ->title('Technical Data page content saved successfully')
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
                                    FileUpload::make('breadcrumb_image')->disk('public')->directory('breadcrumb')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                                ]),
                            Tab::make('FAQ')
                                ->schema([
                                    Repeater::make('faqs')
                                        ->schema([
                                            TextInput::make('question')
                                                ->label('Question'),
                                            Textarea::make('answer')
                                                ->label('Answer'),
                                        ])
                                        ->columns(1),
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
