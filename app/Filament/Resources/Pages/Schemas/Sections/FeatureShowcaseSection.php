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
use Illuminate\Support\Str;

class FeatureShowcaseSection
{
    public static function make(): Block
    {
        return Block::make('feature-showcase')
            ->label('Feature Showcase')
            ->icon('heroicon-o-rectangle-group')
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
                            ->placeholder('Everything you need to manage your server')
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Powerful tools designed to make server management simple.'
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
                                'cards-left' => 'Cards Left',
                                'cards-right' => 'Cards Right',
                            ])
                            ->default('cards-left')
                            ->required()
                            ->native(false),
                    ]),

                Section::make('Showcases')
                    ->description(
                        'Each showcase has its own icon, content and visual. Selecting a card on the frontend switches the large visual panel.'
                    )
                    ->schema([
                        Repeater::make('showcases')
                            ->label('Showcases')
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
                                    ->options([
                                        'server' => 'Server',
                                        'cpu' => 'CPU',
                                        'memory' => 'Memory',
                                        'storage' => 'Storage',
                                        'database' => 'Database',
                                        'network' => 'Network',
                                        'speed' => 'Speed',
                                        'shield' => 'Shield',
                                        'lock' => 'Lock',
                                        'support' => 'Support',
                                        'clock' => 'Clock',
                                        'globe' => 'Globe',
                                        'location' => 'Location',
                                        'cloud' => 'Cloud',
                                        'backup' => 'Backup',
                                        'bandwidth' => 'Bandwidth',
                                        'rocket' => 'Rocket',
                                        'bolt' => 'Bolt',
                                        'users' => 'Users',
                                        'players' => 'Players',
                                        'gamepad' => 'Game',
                                        'terminal' => 'Terminal',
                                        'code' => 'Code',
                                        'desktop' => 'Desktop',
                                        'monitor' => 'Monitor',
                                        'scale' => 'Scale',
                                        'check' => 'Check',
                                        'star' => 'Star',
                                        'cube' => 'Cube',
                                        'settings' => 'Settings',
                                        'tools' => 'Tools',
                                        'key' => 'Key',
                                        'link' => 'Link',
                                        'folder' => 'Folder',
                                        'document' => 'Document',
                                        'download' => 'Download',
                                        'upload' => 'Upload',
                                        'grid' => 'Grid',
                                        'list' => 'List',
                                        'sparkles' => 'Sparkles',
                                        'fire' => 'Fire',
                                        'bug' => 'Bug',
                                        'plugin' => 'Plugin',
                                        'window' => 'Window',
                                        'mobile' => 'Mobile',
                                        'wifi' => 'Wi-Fi',
                                        'cloud-download' => 'Cloud Download',
                                        'cloud-upload' => 'Cloud Upload',
                                    ])
                                    ->searchable()
                                    ->native(false)
                                    ->placeholder('Select icon'),

                                TextInput::make('title')
                                    ->label('Title')
                                    ->placeholder('Shell Access')
                                    ->required()
                                    ->maxLength(120),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->placeholder(
                                        'Manage your server directly with powerful built-in tools.'
                                    )
                                    ->rows(3)
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpanFull(),

                                FileUpload::make('visual')
                                    ->label('Visual / Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('feature-showcase')
                                    ->visibility('public')
                                    ->imagePreviewHeight('220')
                                    ->downloadable()
                                    ->openable()
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable(false)
                            ->itemLabel(
                                fn (array $state): string =>
                                    trim((string) ($state['title'] ?? '')) !== ''
                                        ? (string) $state['title']
                                        : 'Showcase'
                            )
                            ->addActionLabel('Add Showcase')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
