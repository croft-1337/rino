<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\SocialLink;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SiteSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup =
        'Website';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel =
        'Site Settings';

    protected static ?string $title =
        'Site Settings';

    protected static ?int $navigationSort =
        1;

    protected string $view =
        'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $socialLinks =
            SocialLink::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(
                    fn (SocialLink $social): array => [
                        'id' =>
                            $social->id,

                        'platform' =>
                            $social->platform,

                        'url' =>
                            $social->url,

                        'show_in_header' =>
                            $social->show_in_header,

                        'show_in_footer' =>
                            $social->show_in_footer,
                    ]
                )
                ->values()
                ->all();

        $this->form->fill([
            'site_name' =>
                $this->getSetting(
                    'site_name'
                ),

            'site_tagline' =>
                $this->getSetting(
                    'site_tagline'
                ),

            'contact_email' =>
                $this->getSetting(
                    'contact_email'
                ),

            'site_logo' =>
                $this->getSetting(
                    'site_logo'
                ),

            'site_favicon' =>
                $this->getSetting(
                    'site_favicon'
                ),

            'social_links' =>
                $socialLinks,

            'client_area_label' =>
                $this->getSetting(
                    'client_area_label'
                ) ?: 'Client Area',

            'client_area_links' =>
                $this->decodeJson(
                    $this->getSetting(
                        'client_area_links'
                    ),
                    []
                ),
        ]);
    }

    public function form(
        Schema $schema
    ): Schema {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('General')
                    ->description(
                        'Manage your website identity and general information.'
                    )
                    ->schema([
                        TextInput::make(
                            'site_name'
                        )
                            ->label(
                                'Site Name'
                            )
                            ->required()
                            ->maxLength(255),

                        TextInput::make(
                            'site_tagline'
                        )
                            ->label(
                                'Site Tagline'
                            )
                            ->maxLength(255),

                        TextInput::make(
                            'contact_email'
                        )
                            ->label(
                                'Contact Email'
                            )
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Branding')
                    ->description(
                        'Manage your website logo and favicon. Theme colors are controlled from Appearance → Colors.'
                    )
                    ->schema([
                        FileUpload::make(
                            'site_logo'
                        )
                            ->label(
                                'Site Logo'
                            )
                            ->image()
                            ->disk(
                                'public'
                            )
                            ->directory(
                                'branding'
                            )
                            ->visibility(
                                'public'
                            ),

                        FileUpload::make(
                            'site_favicon'
                        )
                            ->label(
                                'Favicon'
                            )
                            ->image()
                            ->disk(
                                'public'
                            )
                            ->directory(
                                'branding'
                            )
                            ->visibility(
                                'public'
                            ),
                    ])
                    ->columns(2),

                Section::make('Social Links')
                    ->description(
                        'Manage shared social links for the header and footer. A maximum of 3 can appear in the header.'
                    )
                    ->schema([
                        Repeater::make(
                            'social_links'
                        )
                            ->label('')
                            ->schema([
                                Hidden::make(
                                    'id'
                                ),

                                Select::make(
                                    'platform'
                                )
                                    ->label(
                                        'Platform'
                                    )
                                    ->options([
                                        'discord' =>
                                            'Discord',

                                        'x' =>
                                            'X / Twitter',

                                        'github' =>
                                            'GitHub',

                                        'youtube' =>
                                            'YouTube',

                                        'facebook' =>
                                            'Facebook',

                                        'instagram' =>
                                            'Instagram',

                                        'linkedin' =>
                                            'LinkedIn',

                                        'tiktok' =>
                                            'TikTok',

                                        'twitch' =>
                                            'Twitch',

                                        'reddit' =>
                                            'Reddit',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                                TextInput::make(
                                    'url'
                                )
                                    ->label(
                                        'URL'
                                    )
                                    ->url()
                                    ->required()
                                    ->placeholder(
                                        'https://...'
                                    ),

                                Toggle::make(
                                    'show_in_header'
                                )
                                    ->label(
                                        'Show in Header'
                                    )
                                    ->live()
                                    ->disabled(
                                        function (
                                            Get $get
                                        ): bool {
                                            $current =
                                                (bool) $get(
                                                    'show_in_header'
                                                );

                                            if ($current) {
                                                return false;
                                            }

                                            $links =
                                                $get(
                                                    '../../social_links'
                                                ) ?? [];

                                            $enabled =
                                                collect(
                                                    $links
                                                )
                                                    ->filter(
                                                        fn (
                                                            $link
                                                        ) =>
                                                            !empty(
                                                                $link[
                                                                    'show_in_header'
                                                                ]
                                                                    ?? false
                                                            )
                                                    )
                                                    ->count();

                                            return $enabled >= 3;
                                        }
                                    )
                                    ->helperText(
                                        'Maximum 3 header social icons.'
                                    ),

                                Toggle::make(
                                    'show_in_footer'
                                )
                                    ->label(
                                        'Show in Footer'
                                    )
                                    ->default(true),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(
                                function (
                                    array $state
                                ): ?string {
                                    return match (
                                        $state[
                                            'platform'
                                        ] ?? null
                                    ) {
                                        'discord' =>
                                            'Discord',

                                        'x' =>
                                            'X / Twitter',

                                        'github' =>
                                            'GitHub',

                                        'youtube' =>
                                            'YouTube',

                                        'facebook' =>
                                            'Facebook',

                                        'instagram' =>
                                            'Instagram',

                                        'linkedin' =>
                                            'LinkedIn',

                                        'tiktok' =>
                                            'TikTok',

                                        'twitch' =>
                                            'Twitch',

                                        'reddit' =>
                                            'Reddit',

                                        default =>
                                            'Social Link',
                                    };
                                }
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Client Area')
                    ->description(
                        'Configure the Client Area dropdown shown on the far-right side of the website header.'
                    )
                    ->schema([
                        TextInput::make(
                            'client_area_label'
                        )
                            ->label(
                                'Button Label'
                            )
                            ->placeholder(
                                'Client Area'
                            )
                            ->required()
                            ->maxLength(80)
                            ->columnSpanFull(),

                        Repeater::make(
                            'client_area_links'
                        )
                            ->label(
                                'Dropdown Links'
                            )
                            ->schema([
                                TextInput::make(
                                    'label'
                                )
                                    ->label(
                                        'Label'
                                    )
                                    ->placeholder(
                                        'Billing Panel'
                                    )
                                    ->required()
                                    ->maxLength(80),

                                TextInput::make(
                                    'url'
                                )
                                    ->label(
                                        'URL'
                                    )
                                    ->placeholder(
                                        'https://billing.example.com'
                                    )
                                    ->url()
                                    ->required(),

                                Select::make(
                                    'icon'
                                )
                                    ->label(
                                        'Icon'
                                    )
                                    ->options([
                                        'none' =>
                                            'None',

                                        'user' =>
                                            'User',

                                        'user-circle' =>
                                            'User Circle',

                                        'credit-card' =>
                                            'Credit Card',

                                        'server' =>
                                            'Server',

                                        'gamepad' =>
                                            'Gamepad',

                                        'dashboard' =>
                                            'Dashboard',

                                        'login' =>
                                            'Login',

                                        'support' =>
                                            'Support',

                                        'globe' =>
                                            'Globe',

                                        'external-link' =>
                                            'External Link',
                                    ])
                                    ->default(
                                        'none'
                                    )
                                    ->native(false),

                                Toggle::make(
                                    'new_tab'
                                )
                                    ->label(
                                        'Open in New Tab'
                                    )
                                    ->default(false),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(
                                fn (
                                    array $state
                                ): ?string =>
                                    $state[
                                        'label'
                                    ] ?? 'Client Area Link'
                            )
                            ->addActionLabel(
                                'Add Link'
                            )
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data =
            $this->form->getState();

        $socialLinks =
            collect(
                $data[
                    'social_links'
                ] ?? []
            )
                ->values();

        $headerCount =
            $socialLinks
                ->filter(
                    fn (array $link): bool =>
                        !empty(
                            $link[
                                'show_in_header'
                            ] ?? false
                        )
                )
                ->count();

        if ($headerCount > 3) {
            Notification::make()
                ->title(
                    'Maximum 3 header social links'
                )
                ->body(
                    'Disable one header social link before enabling another.'
                )
                ->danger()
                ->send();

            return;
        }

        $platforms =
            $socialLinks
                ->pluck(
                    'platform'
                )
                ->filter();

        if (
            $platforms->count()
            !==
            $platforms
                ->unique()
                ->count()
        ) {
            Notification::make()
                ->title(
                    'Duplicate social platform'
                )
                ->body(
                    'Each social platform can only be added once.'
                )
                ->danger()
                ->send();

            return;
        }

        $settings = [
            'site_name' => [
                'value' =>
                    $data[
                        'site_name'
                    ] ?? null,

                'type' =>
                    'text',

                'group' =>
                    'general',
            ],

            'site_tagline' => [
                'value' =>
                    $data[
                        'site_tagline'
                    ] ?? null,

                'type' =>
                    'text',

                'group' =>
                    'general',
            ],

            'contact_email' => [
                'value' =>
                    $data[
                        'contact_email'
                    ] ?? null,

                'type' =>
                    'email',

                'group' =>
                    'contact',
            ],

            'site_logo' => [
                'value' =>
                    $data[
                        'site_logo'
                    ] ?? null,

                'type' =>
                    'image',

                'group' =>
                    'branding',
            ],

            'site_favicon' => [
                'value' =>
                    $data[
                        'site_favicon'
                    ] ?? null,

                'type' =>
                    'image',

                'group' =>
                    'branding',
            ],

            'client_area_label' => [
                'value' =>
                    $data[
                        'client_area_label'
                    ] ?? 'Client Area',

                'type' =>
                    'text',

                'group' =>
                    'header',
            ],

            'client_area_links' => [
                'value' =>
                    json_encode(
                        $data[
                            'client_area_links'
                        ] ?? [],
                        JSON_UNESCAPED_SLASHES
                    ),

                'type' =>
                    'json',

                'group' =>
                    'header',
            ],
        ];

        foreach (
            $settings as $key => $setting
        ) {
            Setting::updateOrCreate(
                [
                    'key' =>
                        $key,
                ],
                $setting
            );
        }

        $existingIds =
            SocialLink::query()
                ->pluck(
                    'id'
                );

        $savedIds =
            collect();

        foreach (
            $socialLinks as $index => $link
        ) {
            $social = null;

            if (
                !empty(
                    $link[
                        'id'
                    ]
                )
            ) {
                $social =
                    SocialLink::query()
                        ->find(
                            $link[
                                'id'
                            ]
                        );
            }

            if (!$social) {
                $social =
                    new SocialLink();
            }

            $social->fill([
                'platform' =>
                    $link[
                        'platform'
                    ],

                'url' =>
                    $link[
                        'url'
                    ],

                'show_in_header' =>
                    !empty(
                        $link[
                            'show_in_header'
                        ]
                    ),

                'show_in_footer' =>
                    !empty(
                        $link[
                            'show_in_footer'
                        ]
                    ),

                'sort_order' =>
                    $index + 1,
            ]);

            $social->save();

            $savedIds->push(
                $social->id
            );
        }

        $deleteIds =
            $existingIds->diff(
                $savedIds
            );

        if (
            $deleteIds->isNotEmpty()
        ) {
            SocialLink::query()
                ->whereIn(
                    'id',
                    $deleteIds
                )
                ->delete();
        }

        $this->removeObsoleteSettings();

        Notification::make()
            ->title(
                'Settings saved'
            )
            ->success()
            ->send();

        $this->mount();
    }

    private function removeObsoleteSettings(): void
    {
        Setting::query()
            ->whereIn(
                'key',
                [
                    'brand_color',

                    'footer_columns',

                    'footer_discord_url',
                    'footer_x_url',
                    'footer_youtube_url',
                    'footer_facebook_url',
                    'footer_instagram_url',
                    'footer_linkedin_url',

                    'client_area_url',
                    'client_area_icon',
                    'client_area_open_new_tab',
                ]
            )
            ->delete();
    }

    private function getSetting(
        string $key
    ): ?string {
        return Setting::query()
            ->where(
                'key',
                $key
            )
            ->value(
                'value'
            );
    }

    private function decodeJson(
        ?string $value,
        array $fallback = []
    ): array {
        if (!$value) {
            return $fallback;
        }

        $decoded =
            json_decode(
                $value,
                true
            );

        return is_array(
            $decoded
        )
            ? $decoded
            : $fallback;
    }
}