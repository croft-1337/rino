<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Footer extends Page
{
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleGroup;

    protected static string|UnitEnum|null $navigationGroup =
        'Website';

    protected static ?string $navigationLabel =
        'Footer';

    protected static ?string $title =
        'Footer';

    protected static ?int $navigationSort =
        5;

    protected string $view =
        'filament.pages.footer';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::query()
            ->where('group', 'footer')
            ->pluck('value', 'key');

        $this->form->fill([
            'footer_description' =>
                $settings->get(
                    'footer_description',
                    ''
                ),

            'footer_copyright' =>
                $settings->get(
                    'footer_copyright',
                    '© ' .
                    date('Y') .
                    ' Rino. All rights reserved.'
                ),

            'footer_show_payments' =>
                $this->boolean(
                    $settings->get(
                        'footer_show_payments',
                        true
                    )
                ),

            'footer_show_site_logo' =>
                $this->boolean(
                    $settings->get(
                        'footer_show_site_logo',
                        true
                    )
                ),

            'footer_payment_methods' =>
                $this->decodeJson(
                    $settings->get(
                        'footer_payment_methods'
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
                        'Footer columns are generated automatically from Categories and Pages. Social links are managed from Site Settings.'
                    )
                    ->schema([

                        Toggle::make(
                            'footer_show_site_logo'
                        )
                            ->label(
                                'Show Site Logo'
                            )
                            ->default(true),

                        Textarea::make(
                            'footer_description'
                        )
                            ->label(
                                'Description'
                            )
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder(
                                'Fast, reliable hosting built for modern projects.'
                            )
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Payment Methods')
                    ->description(
                        'Upload and manage the payment methods displayed in the footer.'
                    )
                    ->schema([

                        Toggle::make(
                            'footer_show_payments'
                        )
                            ->label(
                                'Show Payment Methods'
                            )
                            ->default(true)
                            ->live(),

                        Repeater::make(
                            'footer_payment_methods'
                        )
                            ->label(
                                'Payment Methods'
                            )
                            ->schema([

                                TextInput::make(
                                    'name'
                                )
                                    ->label(
                                        'Name'
                                    )
                                    ->placeholder(
                                        'Visa'
                                    )
                                    ->required()
                                    ->maxLength(80),

                                TextInput::make(
                                    'alt'
                                )
                                    ->label(
                                        'Alt Text'
                                    )
                                    ->placeholder(
                                        'Visa'
                                    )
                                    ->maxLength(120),

                                FileUpload::make(
                                    'logo'
                                )
                                    ->label(
                                        'Logo'
                                    )
                                    ->image()
                                    ->disk(
                                        'public'
                                    )
                                    ->directory(
                                        'payment-methods'
                                    )
                                    ->visibility(
                                        'public'
                                    )
                                    ->required()
                                    ->imagePreviewHeight(
                                        '60'
                                    )
                                    ->columnSpanFull(),

                                Toggle::make(
                                    'enabled'
                                )
                                    ->label(
                                        'Enabled'
                                    )
                                    ->default(true),

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
                                        'name'
                                    ] ?? 'Payment Method'
                            )
                            ->addActionLabel(
                                'Add Payment Method'
                            )
                            ->columnSpanFull(),

                    ]),

                Section::make('Bottom Bar')
                    ->schema([

                        TextInput::make(
                            'footer_copyright'
                        )
                            ->label(
                                'Copyright Text'
                            )
                            ->maxLength(255)
                            ->columnSpanFull(),

                    ]),

            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(
                    'Save Changes'
                )
                ->submit(
                    'save'
                ),
        ];
    }

    public function save(): void
    {
        $data =
            $this->form->getState();

        $paymentMethods =
            array_values(
                $data[
                    'footer_payment_methods'
                ] ?? []
            );

        $settings = [
            'footer_description' => [
                'value' =>
                    $data[
                        'footer_description'
                    ] ?? '',

                'type' =>
                    'text',
            ],

            'footer_copyright' => [
                'value' =>
                    $data[
                        'footer_copyright'
                    ] ?? '',

                'type' =>
                    'text',
            ],

            'footer_show_payments' => [
                'value' =>
                    !empty(
                        $data[
                            'footer_show_payments'
                        ]
                    )
                        ? '1'
                        : '0',

                'type' =>
                    'boolean',
            ],

            'footer_show_site_logo' => [
                'value' =>
                    !empty(
                        $data[
                            'footer_show_site_logo'
                        ]
                    )
                        ? '1'
                        : '0',

                'type' =>
                    'boolean',
            ],

            'footer_payment_methods' => [
                'value' =>
                    json_encode(
                        $paymentMethods,
                        JSON_UNESCAPED_SLASHES
                    ),

                'type' =>
                    'json',
            ],
        ];

        foreach (
            $settings as $key => $setting
        ) {
            Setting::updateOrCreate(
                [
                    'key' => $key,
                ],
                [
                    'value' =>
                        $setting[
                            'value'
                        ],

                    'type' =>
                        $setting[
                            'type'
                        ],

                    'group' =>
                        'footer',
                ]
            );
        }

        Notification::make()
            ->title(
                'Footer settings saved'
            )
            ->success()
            ->send();

        $this->mount();
    }

    private function boolean(
        mixed $value
    ): bool {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
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