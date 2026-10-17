<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class CustomSection
{
    public static function make(): Block
    {
        return Block::make('custom-section')
            ->label('Custom Section')
            ->icon('heroicon-o-code-bracket')
            ->schema([
                Section::make('General')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true),

                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder('Custom Section')
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Optional short description shown above your custom code.'
                            )
                            ->rows(3)
                            ->maxLength(700)
                            ->columnSpanFull(),
                    ]),

                Section::make('Custom Code')
                    ->description(
                        'Custom HTML, CSS, and JavaScript are rendered directly on the frontend. Use only trusted code.'
                    )
                    ->schema([
                        Textarea::make('html')
                            ->label('HTML')
                            ->placeholder(
                                '<div class="custom-content">Your HTML here</div>'
                            )
                            ->rows(14)
                            ->extraInputAttributes([
                                'class' => 'font-mono',
                                'spellcheck' => 'false',
                            ])
                            ->columnSpanFull(),

                        Textarea::make('css')
                            ->label('CSS')
                            ->placeholder(
                                '.custom-content { display: grid; gap: 1rem; }'
                            )
                            ->rows(12)
                            ->extraInputAttributes([
                                'class' => 'font-mono',
                                'spellcheck' => 'false',
                            ])
                            ->columnSpanFull(),

                        Textarea::make('javascript')
                            ->label('JavaScript')
                            ->placeholder(
                                'console.log("Custom section loaded");'
                            )
                            ->rows(12)
                            ->extraInputAttributes([
                                'class' => 'font-mono',
                                'spellcheck' => 'false',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}