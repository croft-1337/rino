<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class TestimonialsSection
{
    public static function make(): Block
    {
        return Block::make('testimonials')
            ->label('Testimonials')
            ->icon('heroicon-o-chat-bubble-left-right')
            ->schema([
                Section::make('General')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true)
                            ->live(),

                        Select::make('alignment')
                            ->label('Alignment')
                            ->options([
                                'left' => 'Left',
                                'center' => 'Center',
                            ])
                            ->default('center')
                            ->required()
                            ->native(false)
                            ->live(),

                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder('Trusted by server owners')
                            ->maxLength(180)
                            ->live(onBlur: true)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'See what customers say about their experience with our hosting.'
                            )
                            ->rows(3)
                            ->maxLength(700)
                            ->live(onBlur: true)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Display')
                    ->schema([
                        Select::make('layout')
                            ->label('Layout')
                            ->options([
                                'grid' => 'Grid',
                                'featured' => 'Featured',
                            ])
                            ->default('grid')
                            ->required()
                            ->native(false)
                            ->live(),
                    ]),

                Section::make('Testimonials')
                    ->schema([
                        Repeater::make('testimonials')
                            ->label('Testimonials')
                            ->schema([
                                Toggle::make('enabled')
                                    ->label('Enabled')
                                    ->default(true)
                                    ->live(),

                                TextInput::make('name')
                                    ->label('Name')
                                    ->placeholder('Alex Carter')
                                    ->required()
                                    ->maxLength(120)
                                    ->live(onBlur: true)
                                    ->dehydrated(true),

                                TextInput::make('role')
                                    ->label('Role / Company')
                                    ->placeholder(
                                        'Minecraft Server Owner'
                                    )
                                    ->maxLength(160)
                                    ->live(onBlur: true)
                                    ->dehydrated(true),

                                FileUpload::make('avatar')
                                    ->label('Avatar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('testimonials')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imageCropAspectRatio('1:1')
                                    ->imagePreviewHeight('120')
                                    ->downloadable()
                                    ->openable()
                                    ->dehydrated(true)
                                    ->columnSpanFull(),

                                Textarea::make('quote')
                                    ->label('Quote')
                                    ->placeholder(
                                        'Setup was fast and the panel is really easy to use.'
                                    )
                                    ->rows(4)
                                    ->required()
                                    ->maxLength(1000)
                                    ->live(onBlur: true)
                                    ->dehydrated(true)
                                    ->columnSpanFull(),

                                Select::make('rating')
                                    ->label('Rating')
                                    ->options([
                                        '1' => '1 Star',
                                        '2' => '2 Stars',
                                        '3' => '3 Stars',
                                        '4' => '4 Stars',
                                        '5' => '5 Stars',
                                    ])
                                    ->placeholder('No rating')
                                    ->native(false)
                                    ->live()
                                    ->dehydrated(true),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable(false)
                            ->dehydrated(true)
                            ->itemLabel(
                                fn (array $state): string =>
                                    filled($state['name'] ?? null)
                                        ? (string) $state['name']
                                        : 'Testimonial'
                            )
                            ->addActionLabel('Add Testimonial')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}