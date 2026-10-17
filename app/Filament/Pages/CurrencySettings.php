<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Support\Currency\CurrencyRateService;
use App\Support\Currency\CurrencyRegistry;
use App\Support\Currency\CurrencyService;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Throwable;

class CurrencySettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-banknotes';

    protected static ?string $navigationLabel =
        'Currency';

    protected static ?string $title =
        'Currency';

    protected static string|\UnitEnum|null $navigationGroup =
        'Website';

    protected static ?int $navigationSort =
        20;

    protected string $view =
        'filament.pages.currency-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings =
            Setting::query()
                ->pluck(
                    'value',
                    'key'
                );

        $defaultCurrency =
            strtoupper(
                (string) $settings->get(
                    'default_currency',
                    'USD'
                )
            );

        $enabledCurrencies =
            json_decode(
                (string) $settings->get(
                    'enabled_currencies',
                    '["USD"]'
                ),
                true
            );

        if (
            !is_array(
                $enabledCurrencies
            )
        ) {
            $enabledCurrencies = [
                $defaultCurrency,
            ];
        }

        $enabledCurrencies =
            collect(
                $enabledCurrencies
            )
                ->map(
                    fn ($currency) =>
                        strtoupper(
                            (string) $currency
                        )
                )
                ->filter()
                ->unique()
                ->values()
                ->all();

        if (
            !in_array(
                $defaultCurrency,
                $enabledCurrencies,
                true
            )
        ) {
            array_unshift(
                $enabledCurrencies,
                $defaultCurrency
            );
        }

        $rateMode =
            (string) $settings->get(
                'currency_rate_mode',
                'automatic'
            );

        if (
            !in_array(
                $rateMode,
                [
                    'automatic',
                    'manual',
                ],
                true
            )
        ) {
            $rateMode =
                'automatic';
        }

        $manualRates =
            json_decode(
                (string) $settings->get(
                    'currency_manual_rates',
                    '{}'
                ),
                true
            );

        if (
            !is_array(
                $manualRates
            )
        ) {
            $manualRates = [];
        }

        $manualRateRows =
            collect(
                $enabledCurrencies
            )
                ->reject(
                    fn (string $currency) =>
                        $currency ===
                        $defaultCurrency
                )
                ->map(
                    fn (string $currency) => [
                        'currency' =>
                            $currency,

                        'rate' =>
                            $manualRates[
                                $currency
                            ]
                            ?? null,
                    ]
                )
                ->values()
                ->all();

        $this->form->fill([
            'default_currency' =>
                $defaultCurrency,

            'enabled_currencies' =>
                $enabledCurrencies,

            'currency_rate_mode' =>
                $rateMode,

            'manual_rates' =>
                $manualRateRows,
        ]);
    }

    public function form(
        Schema $schema
    ): Schema {
        return $schema
            ->components([
                Section::make(
                    'Currency Settings'
                )
                    ->description(
                        'Configure the base currency and currencies available to visitors.'
                    )
                    ->schema([
                        Select::make(
                            'default_currency'
                        )
                            ->label(
                                'Base Currency'
                            )
                            ->options(
                                CurrencyRegistry::options()
                            )
                            ->searchable()
                            ->required()
                            ->live(),

                        Select::make(
                            'enabled_currencies'
                        )
                            ->label(
                                'Enabled Currencies'
                            )
                            ->options(
                                CurrencyRegistry::options()
                            )
                            ->multiple()
                            ->searchable()
                            ->required()
                            ->helperText(
                                'These currencies appear in the website currency selector.'
                            ),
                    ])
                    ->columns(2),

                Section::make(
                    'Exchange Rates'
                )
                    ->description(
                        'Choose whether Rino should use automatically fetched exchange rates or rates entered manually.'
                    )
                    ->schema([
                        Select::make(
                            'currency_rate_mode'
                        )
                            ->label(
                                'Rate Mode'
                            )
                            ->options([
                                'automatic' =>
                                    'Automatic',

                                'manual' =>
                                    'Manual',
                            ])
                            ->default(
                                'automatic'
                            )
                            ->required()
                            ->live()
                            ->helperText(
                                'Automatic rates are fetched from the configured exchange-rate provider. Manual mode uses only the rates entered below.'
                            ),

                        Repeater::make(
                            'manual_rates'
                        )
                            ->label(
                                'Manual Exchange Rates'
                            )
                            ->schema([
                                Select::make(
                                    'currency'
                                )
                                    ->label(
                                        'Currency'
                                    )
                                    ->options(
                                        CurrencyRegistry::options()
                                    )
                                    ->searchable()
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                                TextInput::make(
                                    'rate'
                                )
                                    ->label(
                                        'Rate'
                                    )
                                    ->numeric()
                                    ->minValue(
                                        0.000001
                                    )
                                    ->step(
                                        '0.000001'
                                    )
                                    ->required()
                                    ->helperText(
                                        'Value of 1 base-currency unit in this currency.'
                                    ),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel(
                                'Add Manual Rate'
                            )
                            ->visible(
                                fn ($get) =>
                                    $get(
                                        'currency_rate_mode'
                                    )
                                    ===
                                    'manual'
                            ),
                    ]),
            ])
            ->statePath(
                'data'
            );
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make(
                'refreshRates'
            )
                ->label(
                    'Refresh Rates Now'
                )
                ->icon(
                    'heroicon-o-arrow-path'
                )
                ->color(
                    'primary'
                )
                ->visible(
                    fn (): bool =>
                        app(
                            CurrencyService::class
                        )->rateMode()
                        ===
                        'automatic'
                )
                ->requiresConfirmation()
                ->modalHeading(
                    'Refresh exchange rates?'
                )
                ->modalDescription(
                    'Rino will fetch the latest available rates and replace the cached automatic rates.'
                )
                ->action(
                    function (
                        CurrencyRateService $rates
                    ): void {
                        try {
                            $result =
                                $rates->refresh();

                            Notification::make()
                                ->title(
                                    'Exchange rates refreshed'
                                )
                                ->body(
                                    count(
                                        $result
                                    )
                                    .
                                    ' currencies updated.'
                                )
                                ->success()
                                ->send();
                        } catch (
                            Throwable $exception
                        ) {
                            Notification::make()
                                ->title(
                                    'Rate refresh failed'
                                )
                                ->body(
                                    $exception
                                        ->getMessage()
                                )
                                ->danger()
                                ->send();
                        }
                    }
                ),

            Action::make(
                'save'
            )
                ->label(
                    'Save Changes'
                )
                ->icon(
                    'heroicon-o-check'
                )
                ->action(
                    'save'
                ),
        ];
    }

    public function save(): void
    {
        $data =
            $this->form
                ->getState();

        $defaultCurrency =
            strtoupper(
                (string) (
                    $data[
                        'default_currency'
                    ]
                    ?? 'USD'
                )
            );

        $enabledCurrencies =
            collect(
                $data[
                    'enabled_currencies'
                ]
                ?? []
            )
                ->map(
                    fn ($currency) =>
                        strtoupper(
                            (string) $currency
                        )
                )
                ->filter(
                    fn (string $currency) =>
                        CurrencyRegistry::exists(
                            $currency
                        )
                )
                ->unique()
                ->values()
                ->all();

        if (
            !in_array(
                $defaultCurrency,
                $enabledCurrencies,
                true
            )
        ) {
            $enabledCurrencies[] =
                $defaultCurrency;
        }

        $rateMode =
            (
                $data[
                    'currency_rate_mode'
                ]
                ?? 'automatic'
            )
            ===
            'manual'
                ? 'manual'
                : 'automatic';

        $manualRates = [];

        foreach (
            $data[
                'manual_rates'
            ]
            ?? []
            as $row
        ) {
            $currency =
                strtoupper(
                    (string) (
                        $row[
                            'currency'
                        ]
                        ?? ''
                    )
                );

            $rate =
                $row[
                    'rate'
                ]
                ?? null;

            if (
                !$currency
                ||
                $currency ===
                    $defaultCurrency
                ||
                !CurrencyRegistry::exists(
                    $currency
                )
                ||
                !in_array(
                    $currency,
                    $enabledCurrencies,
                    true
                )
                ||
                !is_numeric(
                    $rate
                )
                ||
                (float) $rate <= 0
            ) {
                continue;
            }

            $manualRates[
                $currency
            ] =
                (float) $rate;
        }

        $manualRates[
            $defaultCurrency
        ] = 1.0;

        $this->putSetting(
            'default_currency',
            $defaultCurrency,
            'text'
        );

        $this->putSetting(
            'enabled_currencies',
            json_encode(
                $enabledCurrencies,
                JSON_UNESCAPED_SLASHES
                |
                JSON_UNESCAPED_UNICODE
            ),
            'textarea'
        );

        $this->putSetting(
            'currency_rate_mode',
            $rateMode,
            'text'
        );

        $this->putSetting(
            'currency_manual_rates',
            json_encode(
                $manualRates,
                JSON_UNESCAPED_SLASHES
                |
                JSON_UNESCAPED_UNICODE
            ),
            'textarea'
        );

        session()->forget(
            'currency'
        );

        Notification::make()
            ->title(
                'Currency settings saved'
            )
            ->success()
            ->send();
    }

    public function getRateStatus(): array
    {
        $currency =
            app(
                CurrencyService::class
            );

        $settings =
            Setting::query()
                ->pluck(
                    'value',
                    'key'
                );

        $updatedAt =
            $settings->get(
                'currency_rates_updated_at'
            );

        $providerDate =
            $settings->get(
                'currency_rates_provider_date'
            );

        $provider =
            $settings->get(
                'currency_rates_provider',
                'frankfurter'
            );

        return [
            'mode' =>
                $currency->rateMode(),

            'base' =>
                $currency->base(),

            'rates' =>
                $currency->rates(),

            'updated_at' =>
                $updatedAt
                    ? Carbon::parse(
                        $updatedAt
                    )
                        ->format(
                            'M j, Y g:i A'
                        )
                    : null,

            'provider_date' =>
                $providerDate,

            'provider' =>
                ucfirst(
                    (string) $provider
                ),
        ];
    }

    protected function putSetting(
        string $key,
        mixed $value,
        string $type
    ): void {
        Setting::updateOrCreate(
            [
                'key' =>
                    $key,
            ],
            [
                'value' =>
                    (string) $value,

                'type' =>
                    $type,

                'group' =>
                    'currency',
            ]
        );
    }
}