<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AnnouncementBar extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Announcement Bar';

    protected static ?string $title = 'Announcement Bar';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.announcement-bar';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::query()
            ->whereIn('key', [
                'announcement_enabled',
                'announcement_message',
                'announcement_highlight',
                'announcement_dismissible',
                'announcement_link_enabled',
                'announcement_link_text',
                'announcement_link_url',
                'announcement_open_new_tab',
            ])
            ->pluck('value', 'key');

        $this->form->fill([
            'announcement_enabled' => filter_var(
                $settings->get('announcement_enabled', false),
                FILTER_VALIDATE_BOOLEAN
            ),

            'announcement_message' =>
                $settings->get('announcement_message', ''),

            'announcement_highlight' =>
                $settings->get('announcement_highlight', ''),

            'announcement_dismissible' => filter_var(
                $settings->get('announcement_dismissible', true),
                FILTER_VALIDATE_BOOLEAN
            ),

            'announcement_link_enabled' => filter_var(
                $settings->get('announcement_link_enabled', false),
                FILTER_VALIDATE_BOOLEAN
            ),

            'announcement_link_text' =>
                $settings->get('announcement_link_text', ''),

            'announcement_link_url' =>
                $settings->get('announcement_link_url', ''),

            'announcement_open_new_tab' => filter_var(
                $settings->get('announcement_open_new_tab', false),
                FILTER_VALIDATE_BOOLEAN
            ),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Announcement')
                    ->description(
                        'Configure the global announcement bar displayed above the website header.'
                    )
                    ->schema([
                        Toggle::make('announcement_enabled')
                            ->label('Enabled')
                            ->default(false),

                        Textarea::make('announcement_message')
                            ->label('Message')
                            ->placeholder('New Minecraft hosting locations are now available.')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('announcement_highlight')
                            ->label('Highlight / Promo Code')
                            ->placeholder('SAVE20')
                            ->maxLength(100),

                        Toggle::make('announcement_dismissible')
                            ->label('Dismissible')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Link')
                    ->description(
                        'Optionally add a clickable action to the announcement.'
                    )
                    ->schema([
                        Toggle::make('announcement_link_enabled')
                            ->label('Enable Link')
                            ->live(),

                        TextInput::make('announcement_link_text')
                            ->label('Link Text')
                            ->placeholder('Learn More')
                            ->maxLength(100),

                        TextInput::make('announcement_link_url')
                            ->label('Link URL')
                            ->placeholder('/game-hosting')
                            ->maxLength(2048),

                        Toggle::make('announcement_open_new_tab')
                            ->label('Open in New Tab'),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->action('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = [
            'announcement_enabled' =>
                !empty($data['announcement_enabled']) ? '1' : '0',

            'announcement_message' =>
                $data['announcement_message'] ?? '',

            'announcement_highlight' =>
                $data['announcement_highlight'] ?? '',

            'announcement_dismissible' =>
                !empty($data['announcement_dismissible']) ? '1' : '0',

            'announcement_link_enabled' =>
                !empty($data['announcement_link_enabled']) ? '1' : '0',

            'announcement_link_text' =>
                $data['announcement_link_text'] ?? '',

            'announcement_link_url' =>
                $data['announcement_link_url'] ?? '',

            'announcement_open_new_tab' =>
                !empty($data['announcement_open_new_tab']) ? '1' : '0',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => 'text',
                    'group' => 'announcement',
                ]
            );
        }

        Notification::make()
            ->title('Announcement bar saved')
            ->success()
            ->send();
    }
}