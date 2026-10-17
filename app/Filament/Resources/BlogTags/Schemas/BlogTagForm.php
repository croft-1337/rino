<?php

namespace App\Filament\Resources\BlogTags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogTagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                function (
                                    ?string $state,
                                    Set $set,
                                    Get $get
                                ): void {
                                    if (filled($get('slug'))) {
                                        return;
                                    }

                                    $set(
                                        'slug',
                                        Str::slug($state ?? '')
                                    );
                                }
                            ),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(
                                table: 'blog_tags',
                                column: 'slug',
                                ignoreRecord: true
                            )
                            ->maxLength(255)
                            ->dehydrateStateUsing(
                                fn (?string $state): string =>
                                    Str::slug($state ?? '')
                            ),

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
