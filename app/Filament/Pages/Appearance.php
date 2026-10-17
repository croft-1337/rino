<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Appearance extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup =
        'Appearance';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedPaintBrush;

    protected static ?string $navigationLabel =
        'Colors';

    protected static ?string $title =
        'Colors';

    protected static ?int $navigationSort =
        1;

    protected string $view =
        'filament.pages.appearance';

    public ?array $data = [];

    public function mount(): void
    {
        $defaults =
            $this->getRinoBasePalette();

        $preset =
            $this->normalizePreset(
                $this->getSetting(
                    'theme_preset'
                )
                ?: 'default'
            );

        $this->form->fill([
            'theme_default_mode' =>
                $this->getSetting(
                    'theme_default_mode'
                )
                ?: 'dark',

            'theme_allow_switch' =>
                $this->getBooleanSetting(
                    'theme_allow_switch',
                    true
                ),

            'theme_preset' =>
                $preset,

            'dark_background' =>
                $this->getSetting(
                    'dark_background'
                )
                ?: $defaults['dark_background'],

            'dark_surface' =>
                $this->getSetting(
                    'dark_surface'
                )
                ?: $defaults['dark_surface'],

            'dark_surface_secondary' =>
                $this->getSetting(
                    'dark_surface_secondary'
                )
                ?: $defaults['dark_surface_secondary'],

            'dark_border' =>
                $this->getSetting(
                    'dark_border'
                )
                ?: $defaults['dark_border'],

            'dark_text_heading' =>
                $this->getSetting(
                    'dark_text_heading'
                )
                ?: $defaults['dark_text_heading'],

            'dark_text_body' =>
                $this->getSetting(
                    'dark_text_body'
                )
                ?: $defaults['dark_text_body'],

            'dark_text_muted' =>
                $this->getSetting(
                    'dark_text_muted'
                )
                ?: $defaults['dark_text_muted'],

            'dark_primary' =>
                $this->getSetting(
                    'dark_primary'
                )
                ?: $defaults['dark_primary'],

            'dark_primary_hover' =>
                $this->getSetting(
                    'dark_primary_hover'
                )
                ?: $defaults['dark_primary_hover'],

            'dark_primary_text' =>
                $this->getSetting(
                    'dark_primary_text'
                )
                ?: $defaults['dark_primary_text'],

            'light_background' =>
                $this->getSetting(
                    'light_background'
                )
                ?: $defaults['light_background'],

            'light_surface' =>
                $this->getSetting(
                    'light_surface'
                )
                ?: $defaults['light_surface'],

            'light_surface_secondary' =>
                $this->getSetting(
                    'light_surface_secondary'
                )
                ?: $defaults['light_surface_secondary'],

            'light_border' =>
                $this->getSetting(
                    'light_border'
                )
                ?: $defaults['light_border'],

            'light_text_heading' =>
                $this->getSetting(
                    'light_text_heading'
                )
                ?: $defaults['light_text_heading'],

            'light_text_body' =>
                $this->getSetting(
                    'light_text_body'
                )
                ?: $defaults['light_text_body'],

            'light_text_muted' =>
                $this->getSetting(
                    'light_text_muted'
                )
                ?: $defaults['light_text_muted'],

            'light_primary' =>
                $this->getSetting(
                    'light_primary'
                )
                ?: $defaults['light_primary'],

            'light_primary_hover' =>
                $this->getSetting(
                    'light_primary_hover'
                )
                ?: $defaults['light_primary_hover'],

            'light_primary_text' =>
                $this->getSetting(
                    'light_primary_text'
                )
                ?: $defaults['light_primary_text'],
        ]);
    }

    public function form(
        Schema $schema
    ): Schema {
        return $schema
            ->statePath(
                'data'
            )
            ->components([
                Section::make(
                    'Theme'
                )
                    ->description(
                        'Control the default appearance of your website.'
                    )
                    ->schema([
                        Select::make(
                            'theme_default_mode'
                        )
                            ->label(
                                'Default Theme Mode'
                            )
                            ->options([
                                'dark' =>
                                    'Dark',

                                'light' =>
                                    'Light',

                                'system' =>
                                    'System',
                            ])
                            ->required(),

                        Toggle::make(
                            'theme_allow_switch'
                        )
                            ->label(
                                'Allow Visitor Theme Switch'
                            )
                            ->default(
                                true
                            ),

                        Select::make(
                            'theme_preset'
                        )
                            ->label(
                                'Preset Palette'
                            )
                            ->options([
                                'default' =>
                                    'Default',

                                'amber' =>
                                    'Amber',

                                'purple' =>
                                    'Purple',

                                'maroon' =>
                                    'Maroon',

                                'emerald' =>
                                    'Emerald',
                            ])
                            ->live()
                            ->afterStateUpdated(
                                function (
                                    ?string $state
                                ): void {
                                    if (!$state) {
                                        return;
                                    }

                                    $palette =
                                        $this
                                            ->getPresetPalette(
                                                $state
                                            );

                                    $this
                                        ->form
                                        ->fill(
                                            array_merge(
                                                $this->data
                                                    ?? [],
                                                $palette
                                            )
                                        );
                                }
                            )
                            ->required(),
                    ])
                    ->columns(
                        2
                    ),

                Section::make(
                    'Dark Theme Colors'
                )
                    ->description(
                        'Configure the colors used when dark mode is active.'
                    )
                    ->schema([
                        ColorPicker::make(
                            'dark_background'
                        )
                            ->label(
                                'Background'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_surface'
                        )
                            ->label(
                                'Surface'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_surface_secondary'
                        )
                            ->label(
                                'Surface Secondary'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_border'
                        )
                            ->label(
                                'Border'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_text_heading'
                        )
                            ->label(
                                'Heading Text'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_text_body'
                        )
                            ->label(
                                'Body Text'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_text_muted'
                        )
                            ->label(
                                'Muted Text'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_primary'
                        )
                            ->label(
                                'Primary'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_primary_hover'
                        )
                            ->label(
                                'Primary Hover'
                            )
                            ->required(),

                        ColorPicker::make(
                            'dark_primary_text'
                        )
                            ->label(
                                'Primary Text'
                            )
                            ->required(),
                    ])
                    ->columns(
                        2
                    ),

                Section::make(
                    'Light Theme Colors'
                )
                    ->description(
                        'Configure the colors used when light mode is active.'
                    )
                    ->schema([
                        ColorPicker::make(
                            'light_background'
                        )
                            ->label(
                                'Background'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_surface'
                        )
                            ->label(
                                'Surface'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_surface_secondary'
                        )
                            ->label(
                                'Surface Secondary'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_border'
                        )
                            ->label(
                                'Border'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_text_heading'
                        )
                            ->label(
                                'Heading Text'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_text_body'
                        )
                            ->label(
                                'Body Text'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_text_muted'
                        )
                            ->label(
                                'Muted Text'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_primary'
                        )
                            ->label(
                                'Primary'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_primary_hover'
                        )
                            ->label(
                                'Primary Hover'
                            )
                            ->required(),

                        ColorPicker::make(
                            'light_primary_text'
                        )
                            ->label(
                                'Primary Text'
                            )
                            ->required(),
                    ])
                    ->columns(
                        2
                    ),
            ]);
    }

    public function save(): void
    {
        $data =
            $this->form
                ->getState();

        foreach (
            $data
            as $key => $value
        ) {
            Setting::updateOrCreate(
                [
                    'key' =>
                        $key,
                ],
                [
                    'value' =>
                        is_bool(
                            $value
                        )
                            ? (
                                $value
                                    ? '1'
                                    : '0'
                            )
                            : (string) $value,

                    'type' =>
                        $this->getSettingType(
                            $key
                        ),

                    'group' =>
                        'appearance',
                ]
            );
        }

        Notification::make()
            ->title(
                'Color settings saved'
            )
            ->success()
            ->send();
    }

    private function getPresetPalette(
        string $preset
    ): array {
        $base =
            $this->getRinoBasePalette();

        $preset =
            $this->normalizePreset(
                $preset
            );

        $brand =
            match ($preset) {
                'amber' => [
                    'primary' =>
                        '#FFA60C',

                    'hover' =>
                        '#E68F00',
                ],

                'purple' => [
                    'primary' =>
                        '#7C3AED',

                    'hover' =>
                        '#6D28D9',
                ],

                'maroon' => [
                    'primary' =>
                        '#8B1E3F',

                    'hover' =>
                        '#701832',
                ],

                'emerald' => [
                    'primary' =>
                        '#059669',

                    'hover' =>
                        '#047857',
                ],

                default => [
                    'primary' =>
                        '#2563EB',

                    'hover' =>
                        '#1D4ED8',
                ],
            };

        return array_merge(
            $base,
            [
                'dark_primary' =>
                    $brand['primary'],

                'dark_primary_hover' =>
                    $brand['hover'],

                'light_primary' =>
                    $brand['primary'],

                'light_primary_hover' =>
                    $brand['hover'],
            ]
        );
    }

    private function getRinoBasePalette(): array
    {
        return [
            'dark_background' =>
                '#09090b',

            'dark_surface' =>
                '#18181b',

            'dark_surface_secondary' =>
                '#27272a',

            'dark_border' =>
                '#3f3f46',

            'dark_text_heading' =>
                '#ffffff',

            'dark_text_body' =>
                '#d4d4d8',

            'dark_text_muted' =>
                '#a1a1aa',

            'dark_primary' =>
                '#2563EB',

            'dark_primary_hover' =>
                '#1D4ED8',

            'dark_primary_text' =>
                '#ffffff',

            'light_background' =>
                '#ffffff',

            'light_surface' =>
                '#fafafa',

            'light_surface_secondary' =>
                '#f4f4f5',

            'light_border' =>
                '#d4d4d8',

            'light_text_heading' =>
                '#18181b',

            'light_text_body' =>
                '#3f3f46',

            'light_text_muted' =>
                '#71717a',

            'light_primary' =>
                '#2563EB',

            'light_primary_hover' =>
                '#1D4ED8',

            'light_primary_text' =>
                '#ffffff',
        ];
    }

    private function normalizePreset(
        string $preset
    ): string {
        return match ($preset) {
            'rino',
            'ocean' =>
                'default',

            'violet',
            'indigo' =>
                'purple',

            'crimson' =>
                'maroon',

            default =>
                $preset,
        };
    }

    private function getSetting(
        string $key
    ): ?string {
        return Setting::where(
            'key',
            $key
        )->value(
            'value'
        );
    }

    private function getBooleanSetting(
        string $key,
        bool $default = false
    ): bool {
        $value =
            $this->getSetting(
                $key
            );

        if ($value === null) {
            return $default;
        }

        return $value === '1';
    }

    private function getSettingType(
        string $key
    ): string {
        if (
            str_contains(
                $key,
                'background'
            )
            ||
            str_contains(
                $key,
                'surface'
            )
            ||
            str_contains(
                $key,
                'border'
            )
            ||
            str_contains(
                $key,
                'primary'
            )
            ||
            str_contains(
                $key,
                'text_'
            )
        ) {
            return 'color';
        }

        if (
            $key ===
            'theme_allow_switch'
        ) {
            return 'boolean';
        }

        return 'text';
    }
}