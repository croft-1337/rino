<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use UnitEnum;

class Customization extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup =
        'Appearance';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedAdjustmentsHorizontal;

    protected static ?string $navigationLabel =
        'Customization';

    protected static ?string $title =
        'Customization';

    protected static ?int $navigationSort =
        2;

    protected string $view =
        'filament.pages.customization';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'body_font' =>
                $this->getSetting(
                    'body_font'
                )
                ?: 'manrope',

            'heading_font' =>
                $this->getSetting(
                    'heading_font'
                )
                ?: 'manrope',

            'base_font_size' =>
                $this->getSetting(
                    'base_font_size'
                )
                ?: '16',

            'card_radius' =>
                (int) (
                    $this->getSetting(
                        'card_radius'
                    )
                    ?: 12
                ),

            'button_radius' =>
                (int) (
                    $this->getSetting(
                        'button_radius'
                    )
                    ?: 32
                ),

            'input_radius' =>
                (int) (
                    $this->getSetting(
                        'input_radius'
                    )
                    ?: 12
                ),
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
                    'Typography'
                )
                    ->description(
                        'Control the core fonts and overall text size used across your website.'
                    )
                    ->schema([
                        Select::make(
                            'body_font'
                        )
                            ->label(
                                'Body Font'
                            )
                            ->options(
                                $this->fontOptions()
                            )
                            ->searchable()
                            ->required(),

                        Select::make(
                            'heading_font'
                        )
                            ->label(
                                'Heading Font'
                            )
                            ->options(
                                $this->fontOptions()
                            )
                            ->searchable()
                            ->required(),

                        Select::make(
                            'base_font_size'
                        )
                            ->label(
                                'Base Font Size'
                            )
                            ->options([
                                '15' => '15px',
                                '16' => '16px',
                                '17' => '17px',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Section::make(
                    'Border Radius'
                )
                    ->description(
                        'Control the roundness of cards, buttons and form inputs.'
                    )
                    ->schema([
                        Slider::make(
                            'card_radius'
                        )
                            ->label(
                                'Card Radius'
                            )
                            ->range(
                                minValue: 0,
                                maxValue: 32
                            )
                            ->step(1)
                            ->tooltips(
                                RawJs::make(
                                    '`${$value}px`'
                                )
                            )
                            ->fillTrack(),

                        Slider::make(
                            'button_radius'
                        )
                            ->label(
                                'Button Radius'
                            )
                            ->range(
                                minValue: 0,
                                maxValue: 32
                            )
                            ->step(1)
                            ->tooltips(
                                RawJs::make(
                                    '`${$value}px`'
                                )
                            )
                            ->fillTrack(),

                        Slider::make(
                            'input_radius'
                        )
                            ->label(
                                'Input Radius'
                            )
                            ->range(
                                minValue: 0,
                                maxValue: 32
                            )
                            ->step(1)
                            ->tooltips(
                                RawJs::make(
                                    '`${$value}px`'
                                )
                            )
                            ->fillTrack(),
                    ]),
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
                        (string) $value,

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
                'Customization settings saved'
            )
            ->success()
            ->send();
    }

    private function fontOptions(): array
    {
        return [
            'system' =>
                'System Default',

            'inter' =>
                'Inter',

            'geist' =>
                'Geist',

            'manrope' =>
                'Manrope',

            'dm-sans' =>
                'DM Sans',

            'plus-jakarta-sans' =>
                'Plus Jakarta Sans',

            'outfit' =>
                'Outfit',

            'space-grotesk' =>
                'Space Grotesk',
        ];
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

    private function getSettingType(
        string $key
    ): string {
        if (
            $key === 'card_radius'
            ||
            $key === 'button_radius'
            ||
            $key === 'input_radius'
            ||
            $key === 'base_font_size'
        ) {
            return 'number';
        }

        return 'text';
    }
}