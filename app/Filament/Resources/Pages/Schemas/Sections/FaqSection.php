<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class FaqSection
{
    public static function make(): Block
    {
        return Block::make('faq')
            ->label('FAQ')
            ->icon('heroicon-o-question-mark-circle')
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
                            ->default('center')
                            ->required()
                            ->native(false),

                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder('Frequently Asked Questions')
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Find answers to the most common questions about our hosting services.'
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
                                'centered' => 'Centered Accordion',
                                'split' => 'Split FAQ',
                            ])
                            ->default('centered')
                            ->required()
                            ->native(false)
                            ->live(),
                    ]),

                Section::make('CTA Button')
                    ->visible(
                        fn (Get $get): bool =>
                            $get('layout') === 'split'
                    )
                    ->schema([
                        Toggle::make('cta_enabled')
                            ->label('Enabled')
                            ->default(true)
                            ->live(),

                        TextInput::make('cta_label')
                            ->label('Label')
                            ->placeholder('Contact Support')
                            ->maxLength(80)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('cta_enabled')
                            ),

                        TextInput::make('cta_url')
                            ->label('URL')
                            ->placeholder('/contact')
                            ->maxLength(500)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('cta_enabled')
                            ),

                        Select::make('cta_style')
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
                                    (bool) $get('cta_enabled')
                            ),

                        Select::make('cta_icon')
                            ->label('Icon')
                            ->options(
                                self::buttonIconOptions()
                            )
                            ->default('arrow-right')
                            ->searchable()
                            ->native(false)
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('cta_enabled')
                                    &&
                                    $get('cta_style') ===
                                        'icon-circle'
                            ),
                    ])
                    ->columns(2),

                Section::make('Questions')
                    ->schema([
                        Repeater::make('questions')
                            ->label('Questions')
                            ->schema([
                                Hidden::make('id')
                                    ->default(
                                        fn (): string =>
                                            (string) Str::uuid()
                                    ),

                                Toggle::make('enabled')
                                    ->label('Enabled')
                                    ->default(true),

                                TextInput::make('question')
                                    ->label('Question')
                                    ->placeholder(
                                        'What types of hosting do you offer?'
                                    )
                                    ->required()
                                    ->maxLength(220)
                                    ->columnSpanFull(),

                                Textarea::make('answer')
                                    ->label('Answer')
                                    ->placeholder(
                                        'We offer a range of hosting services designed for different workloads and use cases.'
                                    )
                                    ->rows(4)
                                    ->required()
                                    ->maxLength(1800)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable(false)
                            ->itemLabel(
                                fn (array $state): string =>
                                    trim(
                                        (string) (
                                            $state['question']
                                            ?? ''
                                        )
                                    ) !== ''
                                        ? (string) $state['question']
                                        : 'Question'
                            )
                            ->addActionLabel('Add Question')
                            ->columnSpanFull(),
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
