<?php

namespace App\Filament\Resources\KnowledgebaseArticles\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KnowledgebaseArticleForm
{
    public static function configure(
        Schema $schema
    ): Schema {
        return $schema
            ->components([
                Section::make('Article')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
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
                                'Used in the article URL.'
                            ),

                        Select::make(
                            'knowledgebase_category_id'
                        )
                            ->label('Category')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name'
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make(
                            'short_description'
                        )
                            ->label('Short Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255),
                        Textarea::make('seo_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(500),
                        FileUpload::make('seo_social_image')
                            ->label('Social Image')
                            ->image()
                            ->disk('public')
                            ->directory('seo/knowledgebase')
                            ->visibility('public'),
                    ]),

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
