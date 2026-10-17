<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class CtaSection
{
    public static function make(): Block
    {
        return Block::make('cta')
            ->label('CTA')
            ->icon('heroicon-o-megaphone')
            ->schema([
                Section::make('General')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true),

                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder('Ready to get started?')
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Launch your server in minutes with fast, reliable hosting.'
                            )
                            ->rows(3)
                            ->maxLength(700)
                            ->columnSpanFull(),
                    ]),

                Section::make('Display')
                    ->schema([
                        Select::make('layout')
                            ->label('Layout')
                            ->options([
                                'centered' => 'Centered CTA',
                                'split' => 'Split CTA',
                            ])
                            ->default('centered')
                            ->required()
                            ->native(false),
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
                                    (bool) $get('primary_button_enabled')
                            ),

                        TextInput::make('primary_button_url')
                            ->label('URL')
                            ->placeholder('/game-hosting')
                            ->maxLength(500)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('primary_button_enabled')
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
                                    (bool) $get('primary_button_enabled')
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
                                    (bool) $get('primary_button_enabled')
                                    &&
                                    $get('primary_button_style') ===
                                        'icon-circle'
                            ),
                    ])
                    ->columns(2),

                Section::make('Secondary Button')
                    ->schema([
                        Toggle::make('secondary_button_enabled')
                            ->label('Enabled')
                            ->default(false)
                            ->live(),

                        TextInput::make('secondary_button_label')
                            ->label('Label')
                            ->placeholder('Learn More')
                            ->maxLength(80)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('secondary_button_enabled')
                            ),

                        TextInput::make('secondary_button_url')
                            ->label('URL')
                            ->placeholder('/about')
                            ->maxLength(500)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('secondary_button_enabled')
                            ),

                        Select::make('secondary_button_style')
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
                                    (bool) $get('secondary_button_enabled')
                            ),

                        Select::make('secondary_button_icon')
                            ->label('Icon')
                            ->options(
                                self::buttonIconOptions()
                            )
                            ->default('arrow-right')
                            ->searchable()
                            ->native(false)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('secondary_button_enabled')
                                    &&
                                    $get('secondary_button_style') ===
                                        'icon-circle'
                            ),
                    ])
                    ->columns(2),
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