<?php

namespace App\Filament\Resources\KnowledgebaseCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KnowledgebaseCategoryForm
{
    public static function configure(
        Schema $schema
    ): Schema {
        return $schema
            ->components([
                Section::make('Category')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->live(
                                onBlur: true
                            )
                            ->afterStateUpdated(
                                function (
                                    ?string $state,
                                    callable $set
                                ): void {
                                    $set(
                                        'slug',
                                        Str::slug(
                                            $state ?? ''
                                        )
                                    );
                                }
                            ),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                ignoreRecord: true
                            )
                            ->helperText(
                                'Used in the category URL.'
                            ),

                        Textarea::make(
                            'description'
                        )
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Publishing')
                    ->schema([
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])
                    ->columns(2),
            ]);
    }
}