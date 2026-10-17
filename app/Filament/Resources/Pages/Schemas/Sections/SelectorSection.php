<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class SelectorSection
{
    public static function make(): Block
    {
        return Block::make('selector')
            ->label('Selector / Filter')
            ->icon('heroicon-o-adjustments-horizontal')
            ->schema([
                Section::make('General')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true),

                        Select::make('alignment')
                            ->label('Alignment')
                            ->options([
                                'left' => 'Left',
                                'center' => 'Center',
                            ])
                            ->default('left')
                            ->required()
                            ->native(false),

                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder(
                                'Choose your Minecraft Server'
                            )
                            ->maxLength(160)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Filter Groups')
                    ->description(
                        'Normal filters are always shown as cards. Billing Cycle is always shown as a compact pill selector.'
                    )
                    ->schema([
                        Repeater::make('groups')
                            ->label('Groups')
                            ->schema([
                                Hidden::make('id')
                                    ->default(
                                        fn (): string =>
                                            (string) Str::uuid()
                                    ),

                                TextInput::make('name')
                                    ->label('Group Name')
                                    ->placeholder('Location')
                                    ->helperText(
                                        'Shown above normal filter cards.'
                                    )
                                    ->required()
                                    ->maxLength(100),

                                Select::make('type')
                                    ->label('Group Type')
                                    ->options([
                                        'normal' =>
                                            'Normal Filter',

                                        'billing' =>
                                            'Billing Cycle',
                                    ])
                                    ->default('normal')
                                    ->required()
                                    ->native(false)
                                    ->live(),

                                Section::make('Options')
                                    ->description(
                                        'Each option is displayed as a card on the website.'
                                    )
                                    ->schema([
                                        Repeater::make('options')
                                            ->label('')
                                            ->schema([
                                                Hidden::make('id')
                                                    ->default(
                                                        fn (): string =>
                                                            (string)
                                                            Str::uuid()
                                                    ),

                                                Toggle::make(
                                                    'enabled'
                                                )
                                                    ->label(
                                                        'Enabled'
                                                    )
                                                    ->default(
                                                        true
                                                    ),

                                                Toggle::make(
                                                    'default'
                                                )
                                                    ->label(
                                                        'Default Option'
                                                    )
                                                    ->helperText(
                                                        'The visitor sees this option selected first.'
                                                    )
                                                    ->default(
                                                        false
                                                    ),

                                                TextInput::make(
                                                    'name'
                                                )
                                                    ->label(
                                                        'Name'
                                                    )
                                                    ->placeholder(
                                                        'Europe General'
                                                    )
                                                    ->required()
                                                    ->maxLength(
                                                        100
                                                    ),

                                                TextInput::make(
                                                    'short_description'
                                                )
                                                    ->label(
                                                        'Short Description'
                                                    )
                                                    ->placeholder(
                                                        'Germany Frankfurt'
                                                    )
                                                    ->maxLength(
                                                        160
                                                    ),

                                                Select::make(
                                                    'visual_type'
                                                )
                                                    ->label(
                                                        'Visual'
                                                    )
                                                    ->options([
                                                        'none' =>
                                                            'None',

                                                        'built_in' =>
                                                            'Built-in Asset',

                                                        'icon' =>
                                                            'Icon',

                                                        'upload' =>
                                                            'Upload',
                                                    ])
                                                    ->default(
                                                        'none'
                                                    )
                                                    ->required()
                                                    ->native(false)
                                                    ->live(),

                                                Select::make(
                                                    'built_in_asset'
                                                )
                                                    ->label(
                                                        'Built-in Asset'
                                                    )
                                                    ->options(
                                                        self::builtInAssets()
                                                    )
                                                    ->searchable()
                                                    ->native(false)
                                                    ->visible(
                                                        fn (
                                                            Get $get
                                                        ): bool =>
                                                            $get(
                                                                'visual_type'
                                                            )
                                                            ===
                                                            'built_in'
                                                    ),

                                                Select::make(
                                                    'icon'
                                                )
                                                    ->label(
                                                        'Icon'
                                                    )
                                                    ->options(
                                                        self::icons()
                                                    )
                                                    ->searchable()
                                                    ->native(false)
                                                    ->visible(
                                                        fn (
                                                            Get $get
                                                        ): bool =>
                                                            $get(
                                                                'visual_type'
                                                            )
                                                            ===
                                                            'icon'
                                                    ),

                                                FileUpload::make(
                                                    'image'
                                                )
                                                    ->label(
                                                        'Upload'
                                                    )
                                                    ->image()
                                                    ->disk(
                                                        'public'
                                                    )
                                                    ->directory(
                                                        'selector/options'
                                                    )
                                                    ->visibility(
                                                        'public'
                                                    )
                                                    ->visible(
                                                        fn (
                                                            Get $get
                                                        ): bool =>
                                                            $get(
                                                                'visual_type'
                                                            )
                                                            ===
                                                            'upload'
                                                    )
                                                    ->columnSpanFull(),
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
                                                    $state[
                                                        'name'
                                                    ]
                                                    ??
                                                    'Option'
                                            )
                                            ->addActionLabel(
                                                'Add Option'
                                            )
                                            ->columnSpanFull(),
                                    ])
                                    ->visible(
                                        fn (
                                            Get $get
                                        ): bool =>
                                            $get('type')
                                            ===
                                            'normal'
                                    )
                                    ->columnSpanFull(),

                                Section::make(
                                    'Billing Cycle'
                                )
                                    ->description(
                                        'Monthly, yearly and other billing cycles are configured in the Plans section and appear here automatically.'
                                    )
                                    ->schema([])
                                    ->visible(
                                        fn (
                                            Get $get
                                        ): bool =>
                                            $get('type')
                                            ===
                                            'billing'
                                    )
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(
                                function (
                                    array $state
                                ): string {
                                    $name =
                                        $state['name']
                                        ?? 'Filter Group';

                                    $type =
                                        $state['type']
                                        ?? 'normal';

                                    return $type
                                        === 'billing'
                                        ? $name
                                            . ' — Billing'
                                        : $name;
                                }
                            )
                            ->addActionLabel(
                                'Add Filter Group'
                            )
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function builtInAssets(): array
    {
        return [
            'Games' => [
                'minecraft' =>
                    'Minecraft',

                'hytale' =>
                    'Hytale',

                'ark' =>
                    'ARK',

                'cs2' =>
                    'Counter-Strike 2',

                'rust' =>
                    'Rust',

                'fivem' =>
                    'FiveM',
            ],

            'Hardware' => [
                'amd' =>
                    'AMD',

                'intel' =>
                    'Intel',
            ],

            'Locations' => [
                'de' =>
                    'Germany',

                'sg' =>
                    'Singapore',

                'us' =>
                    'United States',

                'gb' =>
                    'United Kingdom',

                'nl' =>
                    'Netherlands',

                'fr' =>
                    'France',

                'ca' =>
                    'Canada',

                'au' =>
                    'Australia',
            ],

            'Hosting' => [
                'game-hosting' =>
                    'Game Hosting',

                'vps-hosting' =>
                    'VPS Hosting',

                'web-hosting' =>
                    'Web Hosting',

                'bot-hosting' =>
                    'Bot Hosting',
            ],
        ];
    }

    protected static function icons(): array
    {
        return [
            'server' =>
                'Server',

            'gamepad' =>
                'Gamepad',

            'globe' =>
                'Globe',

            'location' =>
                'Location',

            'cpu' =>
                'Processor',

            'memory' =>
                'Memory',

            'storage' =>
                'Storage',

            'database' =>
                'Database',

            'cloud' =>
                'Cloud',

            'shield' =>
                'Shield',

            'rocket' =>
                'Rocket',

            'terminal' =>
                'Terminal',

            'code' =>
                'Code',

            'desktop' =>
                'Desktop',

            'linux' =>
                'Linux',

            'windows' =>
                'Windows',
        ];
    }
}