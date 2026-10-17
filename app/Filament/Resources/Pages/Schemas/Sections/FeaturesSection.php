<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class FeaturesSection
{
    public static function make(): Block
    {
        return Block::make('features')
            ->label('Features')
            ->icon('heroicon-o-squares-2x2')
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
                            ->placeholder('Why Choose Rino Hosting?')
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Powerful infrastructure and gamer-first features built for reliable hosting.'
                            )
                            ->rows(3)
                            ->maxLength(700)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Display')
                    ->schema([
                        Select::make('layout')
                            ->label('Layout')
                            ->options([
                                'grid' => 'Grid',
                                'split-grid' => 'Split Grid',
                            ])
                            ->default('grid')
                            ->required()
                            ->native(false)
                            ->live(),
                    ]),

                Section::make('Features')
                    ->description(
                        'Add the benefits or capabilities you want to highlight.'
                    )
                    ->schema([
                        Repeater::make('items')
                            ->label('Features')
                            ->schema([
                                Hidden::make('id')
                                    ->default(
                                        fn (): string =>
                                            (string) Str::uuid()
                                    ),

                                Toggle::make('enabled')
                                    ->label('Enabled')
                                    ->default(true),

                                Select::make('icon')
                                    ->label('Icon')
                                    ->options(
                                        self::iconOptions()
                                    )
                                    ->default('server')
                                    ->searchable()
                                    ->native(false)
                                    ->required(
                                        fn (Get $get): bool =>
                                            self::layoutIsGrid($get)
                                    )
                                    ->visible(
                                        fn (Get $get): bool =>
                                            self::layoutIsGrid($get)
                                    )
                                    ->dehydratedWhenHidden(),

                                TextInput::make('title')
                                    ->label('Title')
                                    ->placeholder('High Performance')
                                    ->required()
                                    ->maxLength(120),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->placeholder(
                                        'Fast infrastructure designed for smooth and reliable performance.'
                                    )
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->columnSpanFull(),

                                Section::make('Visual')
                                    ->schema([
                                        Select::make('visual_type')
                                            ->label('Visual Type')
                                            ->options([
                                                'upload' => 'Image Upload',
                                                'html' => 'HTML / Embed',
                                            ])
                                            ->default('upload')
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->dehydratedWhenHidden(),

                                        FileUpload::make('image')
                                            ->label('Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('features')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->required(
                                                fn (Get $get): bool =>
                                                    $get('visual_type') ===
                                                    'upload'
                                            )
                                            ->visible(
                                                fn (Get $get): bool =>
                                                    $get('visual_type') ===
                                                    'upload'
                                            )
                                            ->dehydratedWhenHidden()
                                            ->columnSpanFull(),

                                        Textarea::make('html')
                                            ->label('HTML / Embed')
                                            ->placeholder(
                                                '<div>...</div>'
                                            )
                                            ->rows(12)
                                            ->required(
                                                fn (Get $get): bool =>
                                                    $get('visual_type') ===
                                                    'html'
                                            )
                                            ->visible(
                                                fn (Get $get): bool =>
                                                    $get('visual_type') ===
                                                    'html'
                                            )
                                            ->dehydratedWhenHidden()
                                            ->columnSpanFull(),
                                    ])
                                    ->visible(
                                        fn (Get $get): bool =>
                                            self::layoutIsSplitGrid($get)
                                    )
                                    ->dehydratedWhenHidden()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['title']
                                    ?? 'Feature'
                            )
                            ->addActionLabel('Add Feature')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function layoutIsGrid(
        Get $get
    ): bool {
        return self::resolveLayout($get) === 'grid';
    }

    protected static function layoutIsSplitGrid(
        Get $get
    ): bool {
        return self::resolveLayout($get) === 'split-grid';
    }

    protected static function resolveLayout(
        Get $get
    ): string {
        $paths = [
            '../../../../layout',
            '../../../layout',
            '../../layout',
            '../layout',
            'layout',
        ];

        foreach ($paths as $path) {
            $layout =
                $get($path);

            if (
                in_array(
                    $layout,
                    [
                        'grid',
                        'split-grid',
                        'bento',
                        'split-list',
                    ],
                    true
                )
            ) {
                if (
                    $layout === 'bento'
                    ||
                    $layout === 'split-list'
                ) {
                    return 'split-grid';
                }

                return $layout;
            }
        }

        return 'grid';
    }

    protected static function iconOptions(): array
    {
        return [
            'server' => 'Server',
            'cpu' => 'CPU / Processor',
            'memory' => 'Memory / RAM',
            'storage' => 'Storage',
            'database' => 'Database',
            'network' => 'Network',
            'speed' => 'Performance / Speed',
            'shield' => 'Protection / Shield',
            'lock' => 'Security / Lock',
            'support' => 'Support',
            'clock' => 'Uptime / Time',
            'globe' => 'Global Network',
            'location' => 'Location',
            'cloud' => 'Cloud',
            'backup' => 'Backup',
            'bandwidth' => 'Bandwidth',
            'rocket' => 'Rocket / Performance',
            'bolt' => 'Power',
            'users' => 'Users',
            'players' => 'Players',
            'gamepad' => 'Gaming',
            'terminal' => 'Terminal',
            'code' => 'Code',
            'desktop' => 'Desktop',
            'monitor' => 'Monitoring',
            'scale' => 'Scalability',
            'check' => 'Check',
            'star' => 'Star',
            'cube' => 'Cube',
        ];
    }
}