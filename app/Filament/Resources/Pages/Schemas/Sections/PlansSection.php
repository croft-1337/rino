<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use App\Models\Page;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class PlansSection
{
    public static function make(): Block
    {
        return Block::make('plans')
            ->label('Plans')
            ->icon('heroicon-o-server-stack')
            ->schema([
                Section::make('General')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true),
                    ]),

                Section::make('Display')
                    ->schema([
                        Select::make('layout')
                            ->label('Layout')
                            ->options([
                                'cards' => 'Cards',
                                'rows' => 'Rows',
                            ])
                            ->default('cards')
                            ->required()
                            ->native(false)
                            ->live(),

                        Select::make('card_style')
                            ->label('Card Style')
                            ->options([
                                'classic' => 'Classic',
                                'visual-right' => 'Visual Right',
                                'visual-top' => 'Visual Top',
                                'minimal' => 'Minimal',
                            ])
                            ->default('classic')
                            ->required()
                            ->native(false)
                            ->visible(
                                fn (Get $get): bool =>
                                    $get('layout') === 'cards'
                            ),

                        Select::make('price_display')
                            ->label('Price Display')
                            ->options([
                                'full-cycle' => 'Full Cycle',
                                'monthly-equivalent' => 'Monthly Equivalent',
                            ])
                            ->default('monthly-equivalent')
                            ->required()
                            ->native(false)
                            ->helperText(
                                'Controls only how prices are shown. Full Cycle shows the complete cycle price, while Monthly Equivalent converts longer cycles to a monthly comparison price.'
                            ),

                        Toggle::make('show_cycle_discount')
                            ->label('Show Savings')
                            ->helperText(
                                'Automatically calculate each plan’s saving compared with the default billing cycle.'
                            )
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Billing Cycles')
                    ->description(
                        'Create the billing periods available in this Plans section. Each plan can then have its own price and checkout URL for these cycles.'
                    )
                    ->schema([
                        Repeater::make('billing_cycles')
                            ->label('Billing Cycles')
                            ->schema([
                                Hidden::make('id')
                                    ->default(
                                        fn (): string =>
                                            (string) Str::uuid()
                                    ),

                                Toggle::make('enabled')
                                    ->label('Enabled')
                                    ->default(true),

                                Toggle::make('default')
                                    ->label('Default Cycle')
                                    ->helperText(
                                        'Visitors see this billing cycle first.'
                                    )
                                    ->default(false),

                                TextInput::make('name')
                                    ->label('Name')
                                    ->placeholder('Monthly')
                                    ->required()
                                    ->maxLength(80),

                                TextInput::make('short_label')
                                    ->label('Short Label')
                                    ->placeholder('mo')
                                    ->helperText(
                                        'Used beside full-cycle prices, for example /mo or /yr.'
                                    )
                                    ->maxLength(20),

                                TextInput::make('months')
                                    ->label('Length')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(120)
                                    ->default(1)
                                    ->suffix('month(s)')
                                    ->helperText(
                                        'Used to calculate monthly-equivalent pricing and automatic savings.'
                                    )
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['name']
                                    ?? 'Billing Cycle'
                            )
                            ->addActionLabel(
                                'Add Billing Cycle'
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Plans')
                    ->description(
                        'Create the hosting plans displayed in this section.'
                    )
                    ->schema([
                        Repeater::make('plans')
                            ->label('Plans')
                            ->schema([
                                Hidden::make('id')
                                    ->default(
                                        fn (): string =>
                                            (string) Str::uuid()
                                    ),

                                Section::make('Basic')
                                    ->schema([
                                        Toggle::make('enabled')
                                            ->label('Enabled')
                                            ->default(true),

                                        TextInput::make('name')
                                            ->label('Plan Name')
                                            ->placeholder(
                                                'Minecraft Starter'
                                            )
                                            ->required()
                                            ->maxLength(120),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->placeholder(
                                                'Optional short description.'
                                            )
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->columnSpanFull(),

                                        Toggle::make('popular')
                                            ->label('Popular')
                                            ->helperText(
                                                'Show the Popular badge for this plan.'
                                            )
                                            ->default(false)
                                            ->live(),

                                        Toggle::make('recommended')
                                            ->label('Recommended')
                                            ->helperText(
                                                'Show the Recommended badge for this plan.'
                                            )
                                            ->default(false)
                                            ->live()
                                            ->disabled(
                                                fn (Get $get): bool =>
                                                    (bool) $get('popular')
                                            ),
                                    ])
                                    ->columns(2),

                                Section::make('Visual')
                                    ->schema([
                                        Select::make('visual_type')
                                            ->label('Visual')
                                            ->options([
                                                'none' => 'None',
                                                'upload' => 'Upload',
                                            ])
                                            ->default('none')
                                            ->required()
                                            ->native(false)
                                            ->live(),

                                        FileUpload::make('image')
                                            ->label('Upload')
                                            ->image()
                                            ->disk('public')
                                            ->directory('plans')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->visible(
                                                fn (Get $get): bool =>
                                                    $get('visual_type')
                                                    === 'upload'
                                            )
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),

                                Section::make('Pricing')
                                    ->description(
                                        'Add the price and checkout link for every billing cycle this plan supports.'
                                    )
                                    ->schema([
                                        Repeater::make('prices')
                                            ->label('Billing Prices')
                                            ->schema([
                                                Hidden::make('id')
                                                    ->default(
                                                        fn (): string =>
                                                            (string) Str::uuid()
                                                    ),

                                                Select::make('cycle_id')
                                                    ->label('Billing Cycle')
                                                    ->options(
                                                        fn (Get $get): array =>
                                                            self::billingCycleOptions(
                                                                $get
                                                            )
                                                    )
                                                    ->searchable()
                                                    ->native(false)
                                                    ->required(),

                                                TextInput::make('price')
                                                    ->label('Price')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->step('0.01')
                                                    ->prefix('$')
                                                    ->helperText(
                                                        'Enter the amount actually charged for this billing cycle.'
                                                    )
                                                    ->required(),

                                                TextInput::make(
                                                    'checkout_url'
                                                )
                                                    ->label('Checkout URL')
                                                    ->placeholder(
                                                        'https://billing.example.com/order/...'
                                                    )
                                                    ->helperText(
                                                        'Use a checkout URL, relative path, or # as a placeholder.'
                                                    )
                                                    ->maxLength(500)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->itemLabel(
                                                function (
                                                    array $state,
                                                    Get $get
                                                ): ?string {
                                                    $cycleId =
                                                        $state['cycle_id']
                                                        ?? null;

                                                    $price =
                                                        $state['price']
                                                        ?? null;

                                                    $cycles =
                                                        self::billingCycleOptions(
                                                            $get
                                                        );

                                                    $cycleName =
                                                        $cycleId
                                                            ? (
                                                                $cycles[
                                                                    $cycleId
                                                                ]
                                                                ??
                                                                'Billing Price'
                                                            )
                                                            : 'Billing Price';

                                                    if (
                                                        filled(
                                                            $price
                                                        )
                                                    ) {
                                                        return $cycleName
                                                            . ' — $'
                                                            . $price;
                                                    }

                                                    return $cycleName;
                                                }
                                            )
                                            ->addActionLabel(
                                                'Add Billing Price'
                                            )
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),

                                Section::make('Specifications')
                                    ->description(
                                        'Add the specification lines displayed with this plan.'
                                    )
                                    ->schema([
                                        Repeater::make('specs')
                                            ->label(
                                                'Specifications'
                                            )
                                            ->schema([
                                                Hidden::make('id')
                                                    ->default(
                                                        fn (): string =>
                                                            (string) Str::uuid()
                                                    ),

                                                TextInput::make('label')
                                                    ->label(
                                                        'Specification'
                                                    )
                                                    ->placeholder(
                                                        '8 GB RAM'
                                                    )
                                                    ->required()
                                                    ->maxLength(160),

                                                Select::make('icon')
                                                    ->label('Icon')
                                                    ->options(
                                                        self::planIconOptions()
                                                    )
                                                    ->searchable()
                                                    ->native(false),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->itemLabel(
                                                fn (
                                                    array $state
                                                ): ?string =>
                                                    $state['label']
                                                    ??
                                                    'Specification'
                                            )
                                            ->addActionLabel(
                                                'Add Specification'
                                            )
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),

                                Section::make(
                                    'Filter Availability'
                                )
                                    ->description(
                                        'Choose the selector options where this plan should appear. Leave empty to show it for every selector choice.'
                                    )
                                    ->schema([
                                        Select::make(
                                            'selector_matches'
                                        )
                                            ->label(
                                                'Available For'
                                            )
                                            ->options(
                                                fn (
                                                    Get $get,
                                                    ?Page $record
                                                ): array =>
                                                    self::selectorOptionOptions(
                                                        $get,
                                                        $record
                                                    )
                                            )
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->helperText(
                                                'You can select more than one location, processor, or other normal filter option.'
                                            )
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(),
                            ])
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['name']
                                    ?? 'Plan'
                            )
                            ->addActionLabel('Add Plan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function billingCycleOptions(
        Get $get
    ): array {
        $paths = [
            '../../../../billing_cycles',
            '../../../billing_cycles',
            '../../billing_cycles',
            '../billing_cycles',
            'billing_cycles',
        ];

        foreach ($paths as $path) {
            $cycles =
                $get($path);

            if (
                !is_array(
                    $cycles
                )
            ) {
                continue;
            }

            $options =
                collect($cycles)
                    ->filter(
                        fn ($cycle): bool =>
                            is_array($cycle)
                            &&
                            (bool) (
                                $cycle['enabled']
                                ?? true
                            )
                            &&
                            filled(
                                $cycle['id']
                                ?? null
                            )
                            &&
                            filled(
                                $cycle['name']
                                ?? null
                            )
                    )
                    ->mapWithKeys(
                        fn ($cycle): array => [
                            (string) $cycle['id']
                                =>
                                $cycle['name'],
                        ]
                    )
                    ->all();

            if (
                $options !== []
            ) {
                return $options;
            }
        }

        return [];
    }

    protected static function selectorOptionOptions(
        Get $get,
        ?Page $record
    ): array {
        $options =
            self::extractSelectorOptions(
                $record?->sections
                ?? []
            );

        if ($options !== []) {
            return $options;
        }

        $paths = [
            '../../../../../../../sections',
            '../../../../../../sections',
            '../../../../../sections',
            '../../../../sections',
            '../../../sections',
        ];

        foreach ($paths as $path) {
            try {
                $state =
                    $get($path);
            } catch (\Throwable) {
                continue;
            }

            $options =
                self::extractSelectorOptions(
                    $state
                );

            if ($options !== []) {
                return $options;
            }
        }

        return [];
    }

    protected static function extractSelectorOptions(
        mixed $value
    ): array {
        if (!is_array($value)) {
            return [];
        }

        $options = [];

        $walk =
            function (
                array $items
            ) use (
                &$walk,
                &$options
            ): void {
                if (
                    ($items['type'] ?? null)
                    ===
                    'selector'
                    &&
                    is_array(
                        $items['data']['groups']
                        ?? null
                    )
                ) {
                    foreach (
                        $items['data']['groups']
                        as $group
                    ) {
                        if (
                            !is_array($group)
                            ||
                            ($group['type'] ?? 'normal')
                            ===
                            'billing'
                            ||
                            blank(
                                $group['id']
                                ?? null
                            )
                        ) {
                            continue;
                        }

                        $groupId =
                            (string) $group['id'];

                        $groupName =
                            filled(
                                $group['name']
                                ?? null
                            )
                                ? (string) $group['name']
                                : 'Filter';

                        foreach (
                            $group['options']
                            ?? []
                            as $option
                        ) {
                            if (
                                !is_array($option)
                                ||
                                blank(
                                    $option['id']
                                    ?? null
                                )
                                ||
                                blank(
                                    $option['name']
                                    ?? null
                                )
                            ) {
                                continue;
                            }

                            $optionId =
                                (string) $option['id'];

                            $options[
                                $groupId
                                . '::'
                                . $optionId
                            ] =
                                $groupName
                                . ' — '
                                . $option['name'];
                        }
                    }
                }

                foreach ($items as $item) {
                    if (is_array($item)) {
                        $walk($item);
                    }
                }
            };

        $walk($value);

        return $options;
    }

    protected static function planIconOptions(): array
    {
        return [
            'server' => 'Server',
            'cpu' => 'CPU / Processor',
            'memory' => 'Memory / RAM',
            'storage' => 'Storage / Disk',
            'database' => 'Database',

            'players' => 'Players',
            'users' => 'Users',

            'network' => 'Network',
            'bandwidth' => 'Bandwidth',

            'shield' => 'Protection / Shield',
            'lock' => 'Security / Lock',

            'support' => 'Support / Headset',
            'clock' => 'Uptime / Time',
            'backup' => 'Backup / Restore',

            'globe' => 'Global / Internet',
            'cloud' => 'Cloud',

            'rocket' => 'Performance / Rocket',
            'bolt' => 'Power / Bolt',

            'gamepad' => 'Game',
            'terminal' => 'Terminal',
            'code' => 'Code',

            'desktop' => 'Desktop',
            'linux' => 'Linux',
            'windows' => 'Windows',

            'check' => 'Check',
        ];
    }
}