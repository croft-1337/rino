<?php

namespace App\Filament\Pages;

use App\Models\Page as SitePage;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class CookieConsent extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup =
        'Website';

    protected static ?string $navigationLabel =
        'Cookie Consent';

    protected static ?string $title =
        'Cookie Consent';

    protected static ?int $navigationSort =
        7;

    protected string $view =
        'filament.pages.cookie-consent';

    public ?array $data = [];

    public function mount(): void
    {
        $settings =
            Setting::query()
                ->where(
                    'group',
                    'cookie_consent'
                )
                ->pluck(
                    'value',
                    'key'
                );

        $this->form->fill([
            'cookie_consent_enabled' =>
                $this->boolean(
                    $settings->get(
                        'cookie_consent_enabled',
                        true
                    )
                ),

            'cookie_consent_title' =>
                $settings->get(
                    'cookie_consent_title',
                    'We use cookies'
                ),

            'cookie_consent_description' =>
                $settings->get(
                    'cookie_consent_description',
                    'We use essential cookies and optional analytics to improve the website.'
                ),

            'cookie_analytics_enabled' =>
                $this->boolean(
                    $settings->get(
                        'cookie_analytics_enabled',
                        true
                    )
                ),

            'cookie_accept_label' =>
                $settings->get(
                    'cookie_accept_label',
                    'Accept'
                ),

            'cookie_reject_label' =>
                $settings->get(
                    'cookie_reject_label',
                    'Reject Optional'
                ),

            'cookie_privacy_page_id' =>
                filled(
                    $settings->get(
                        'cookie_privacy_page_id'
                    )
                )
                    ? (int) $settings->get(
                        'cookie_privacy_page_id'
                    )
                    : null,
        ]);
    }

    public function form(
        Schema $schema
    ): Schema {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Cookie Consent')
                    ->description(
                        'Configure essential and optional analytics cookie consent for the website.'
                    )
                    ->schema([
                        Toggle::make(
                            'cookie_consent_enabled'
                        )
                            ->label(
                                'Enable Cookie Consent'
                            )
                            ->default(true)
                            ->live(),

                        Toggle::make(
                            'cookie_analytics_enabled'
                        )
                            ->label(
                                'Analytics Cookies'
                            )
                            ->helperText(
                                'When disabled, Rino visitor analytics will not track frontend visits.'
                            )
                            ->default(true),

                        TextInput::make(
                            'cookie_consent_title'
                        )
                            ->label('Title')
                            ->required()
                            ->maxLength(150)
                            ->default(
                                'We use cookies'
                            ),

                        Textarea::make(
                            'cookie_consent_description'
                        )
                            ->label('Description')
                            ->rows(4)
                            ->required()
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        TextInput::make(
                            'cookie_accept_label'
                        )
                            ->label(
                                'Accept All Label'
                            )
                            ->required()
                            ->maxLength(60)
                            ->default('Accept'),

                        TextInput::make(
                            'cookie_reject_label'
                        )
                            ->label(
                                'Reject Optional Label'
                            )
                            ->required()
                            ->maxLength(60)
                            ->default(
                                'Reject Optional'
                            ),

                        Select::make(
                            'cookie_privacy_page_id'
                        )
                            ->label(
                                'Privacy Policy'
                            )
                            ->options(
                                fn (): array =>
                                    SitePage::query()
                                        ->where(
                                            'active',
                                            true
                                        )
                                        ->whereIn(
                                            'page_type',
                                            [
                                                SitePage::TYPE_DOCUMENT,
                                                SitePage::TYPE_STRUCTURED,
                                            ]
                                        )
                                        ->orderBy(
                                            'title'
                                        )
                                        ->pluck(
                                            'title',
                                            'id'
                                        )
                                        ->all()
                            )
                            ->searchable()
                            ->preload()
                            ->placeholder(
                                'Select a page'
                            )
                            ->helperText(
                                'Optional page linked from the cookie consent panel.'
                            )
                            ->columnSpanFull(),
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
                ->keyBindings([
                    'mod+s',
                ]),
        ];
    }

    public function save(): void
    {
        $data =
            $this->form->getState();

        $settings = [
            'cookie_consent_enabled' =>
                !empty(
                    $data[
                        'cookie_consent_enabled'
                    ]
                )
                    ? '1'
                    : '0',

            'cookie_consent_title' =>
                $data[
                    'cookie_consent_title'
                ]
                ?? 'We use cookies',

            'cookie_consent_description' =>
                $data[
                    'cookie_consent_description'
                ]
                ?? '',

            'cookie_analytics_enabled' =>
                !empty(
                    $data[
                        'cookie_analytics_enabled'
                    ]
                )
                    ? '1'
                    : '0',

            'cookie_accept_label' =>
                $data[
                    'cookie_accept_label'
                ]
                ?? 'Accept',

            'cookie_reject_label' =>
                $data[
                    'cookie_reject_label'
                ]
                ?? 'Reject Optional',

            'cookie_privacy_page_id' =>
                filled(
                    $data[
                        'cookie_privacy_page_id'
                    ]
                    ?? null
                )
                    ? (string) $data[
                        'cookie_privacy_page_id'
                    ]
                    : '',
        ];

        foreach (
            $settings
            as $key => $value
        ) {
            Setting::updateOrCreate(
                [
                    'key' =>
                        $key,
                ],
                [
                    'value' =>
                        $value,

                    'type' =>
                        'text',

                    'group' =>
                        'cookie_consent',
                ]
            );
        }

        Notification::make()
            ->title(
                'Cookie consent settings saved'
            )
            ->success()
            ->send();
    }

    private function boolean(
        mixed $value
    ): bool {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
        );
    }
}
