<?php

namespace App\Filament\Resources\PageCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageCategoryForm
{
    public static function configure(
        Schema $schema
    ): Schema {
        return $schema
            ->components([

                Section::make('Category')
                    ->description(
                        'Categories group website entries in the header and footer.'
                    )
                    ->schema([

                        TextInput::make('name')
                            ->label('Category Name')
                            ->placeholder(
                                'Game Hosting'
                            )
                            ->required()
                            ->maxLength(255),

                    ]),

            ]);
    }
}