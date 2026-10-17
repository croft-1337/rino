<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class HeroSection
{
public static function make(): Block

{

    return Block::make('hero')

        ->label('Hero')

        ->icon('heroicon-o-sparkles')

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

                ])

                ->columns(2),



            Section::make('Top Element')

                ->schema([

                    Select::make('top_element')

                        ->label('Top Element')

                        ->options([

                            'none' => 'None',

                            'tag' => 'Tag',

                            'social_proof' => 'Social Proof',

                        ])

                        ->default('none')

                        ->required()

                        ->native(false)

                        ->live(),



                    TextInput::make('tag_text')

                        ->label('Tag Text')

                        ->placeholder('Premium Hosting')

                        ->maxLength(120)

                        ->visible(

                            fn (Get $get): bool =>

                                $get('top_element') === 'tag'

                        )

                        ->columnSpanFull(),



                    Repeater::make('social_proof_avatars')

                        ->label('Avatars')

                        ->schema([

                            FileUpload::make('image')

                                ->label('Avatar')

                                ->image()

                                ->disk('public')

                                ->directory('hero/social-proof')

                                ->visibility('public')

                                ->required(),

                        ])

                        ->minItems(1)

                        ->maxItems(4)

                        ->defaultItems(0)

                        ->reorderable()

                        ->collapsible()

                        ->visible(

                            fn (Get $get): bool =>

                                $get('top_element') === 'social_proof'

                        )

                        ->columnSpanFull(),



                    TextInput::make('social_proof_title')

                        ->label('Title')

                        ->placeholder(

                            'Trusted by top customers'

                        )

                        ->maxLength(160)

                        ->visible(

                            fn (Get $get): bool =>

                                $get('top_element') === 'social_proof'

                        )

                        ->columnSpanFull(),



                    TextInput::make('social_proof_subtitle')

                        ->label('Subtitle')

                        ->placeholder(

                            'Trusted by 40+ clients'

                        )

                        ->maxLength(200)

                        ->visible(

                            fn (Get $get): bool =>

                                $get('top_element') === 'social_proof'

                        )

                        ->columnSpanFull(),

                ]),



            Section::make('Content')

                ->schema([

                    TextInput::make('heading')

                        ->label('Heading')

                        ->placeholder(

                            'Power up your Minecraft server with premium hosting'

                        )

                        ->required()

                        ->maxLength(255)

                        ->columnSpanFull(),



                    TextInput::make('highlighted_text')

                        ->label('Highlighted Text')

                        ->helperText(

                            'Enter the exact words from the heading that should use the primary color.'

                        )

                        ->placeholder('Minecraft')

                        ->maxLength(255)

                        ->columnSpanFull(),



                    Textarea::make('description')

                        ->label('Description')

                        ->rows(4)

                        ->maxLength(900)

                        ->columnSpanFull(),

                ]),



            Section::make('Primary Button')

                ->schema([

                    Toggle::make('primary_button_enabled')

                        ->label('Enabled')

                        ->default(true)

                        ->live(),



                    TextInput::make('primary_button_label')

                        ->label('Label')

                        ->placeholder('Get Started')

                        ->maxLength(80)

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'primary_button_enabled'

                                )

                        ),



                    TextInput::make('primary_button_url')

                        ->label('URL')

                        ->placeholder('/game-hosting')

                        ->maxLength(500)

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'primary_button_enabled'

                                )

                        ),



                    Select::make('primary_button_style')

                        ->label('Style')

                        ->options([

                            'normal' => 'Normal',

                            'icon-circle' => 'Icon Circle',

                        ])

                        ->default('icon-circle')

                        ->required()

                        ->native(false)

                        ->live()

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'primary_button_enabled'

                                )

                        ),



                    Select::make('primary_button_icon')

                        ->label('Icon')

                        ->options(

                            self::buttonIconOptions()

                        )

                        ->default('arrow-right')

                        ->searchable()

                        ->native(false)

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'primary_button_enabled'

                                )

                                &&

                                $get(

                                    'primary_button_style'

                                ) === 'icon-circle'

                        ),

                ])

                ->columns(2),



            Section::make('Secondary Button')

                ->schema([

                    Toggle::make(

                        'secondary_button_enabled'

                    )

                        ->label('Enabled')

                        ->default(false)

                        ->live(),



                    TextInput::make(

                        'secondary_button_label'

                    )

                        ->label('Label')

                        ->placeholder('Learn More')

                        ->maxLength(80)

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'secondary_button_enabled'

                                )

                        ),



                    TextInput::make(

                        'secondary_button_url'

                    )

                        ->label('URL')

                        ->placeholder('/about')

                        ->maxLength(500)

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'secondary_button_enabled'

                                )

                        ),



                    Select::make(

                        'secondary_button_style'

                    )

                        ->label('Style')

                        ->options([

                            'normal' => 'Normal',

                            'icon-circle' => 'Icon Circle',

                        ])

                        ->default('normal')

                        ->required()

                        ->native(false)

                        ->live()

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'secondary_button_enabled'

                                )

                        ),



                    Select::make(

                        'secondary_button_icon'

                    )

                        ->label('Icon')

                        ->options(

                            self::buttonIconOptions()

                        )

                        ->default('arrow-right')

                        ->searchable()

                        ->native(false)

                        ->visible(

                            fn (Get $get): bool =>

                                (bool) $get(

                                    'secondary_button_enabled'

                                )

                                &&

                                $get(

                                    'secondary_button_style'

                                ) === 'icon-circle'

                        ),

                ])

                ->columns(2),



            Section::make('Background')

                ->schema([

                    FileUpload::make('background_image')

                        ->label('Image')

                        ->image()

                        ->disk('public')

                        ->directory(

                            'hero/backgrounds'

                        )

                        ->visibility('public')

                        ->imageEditor()

                        ->columnSpanFull(),



                    Select::make('background_position')

                        ->label('Position')

                        ->options([

                            'center' => 'Center',

                            'top' => 'Top',

                            'right' => 'Right',

                        ])

                        ->default('center')

                        ->required()

                        ->native(false),

                ]),

        ]);

}

protected static function buttonIconOptions(): array

{

    return [

        'none' => 'None',

        'arrow-up-right' => 'Arrow Up Right',

        'arrow-right' => 'Arrow Right',

        'arrow-down' => 'Arrow Down',

        'chevron-right' => 'Chevron Right',

        'play' => 'Play',

        'server' => 'Server',

        'gamepad' => 'Gamepad',

        'rocket' => 'Rocket',

        'globe' => 'Globe',

        'external-link' => 'External Link',

    ];

}
}
