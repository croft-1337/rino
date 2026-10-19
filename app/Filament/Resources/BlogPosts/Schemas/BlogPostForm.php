<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\Setting;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(
        Schema $schema
    ): Schema {
        return $schema
            ->columns(1)
            ->components([
                Section::make(
                    'Post Details'
                )
                    ->schema([
                        TextInput::make(
                            'title'
                        )
                            ->label(
                                'Title'
                            )
                            ->required()
                            ->maxLength(
                                255
                            )
                            ->live(
                                onBlur: true
                            )
                            ->afterStateUpdated(
                                function (
                                    ?string $state,
                                    Set $set,
                                    Get $get
                                ): void {
                                    if (
                                        filled(
                                            $get(
                                                'slug'
                                            )
                                        )
                                    ) {
                                        return;
                                    }

                                    $set(
                                        'slug',
                                        Str::slug(
                                            $state
                                            ?? ''
                                        )
                                    );
                                }
                            ),

                        TextInput::make(
                            'slug'
                        )
                            ->label(
                                'Slug'
                            )
                            ->required()
                            ->unique(
                                table:
                                    'blog_posts',

                                column:
                                    'slug',

                                ignoreRecord:
                                    true
                            )
                            ->maxLength(
                                255
                            )
                            ->dehydrateStateUsing(
                                fn (
                                    ?string $state
                                ): string =>
                                    Str::slug(
                                        $state
                                        ?? ''
                                    )
                            )
                            ->prefix(
                                fn (): string =>
                                    '/'
                                    .
                                    self::blogSlug()
                                    .
                                    '/'
                            ),

                        Select::make(
                            'tags'
                        )
                            ->label(
                                'Tags'
                            )
                            ->relationship(
                                name:
                                    'tags',

                                titleAttribute:
                                    'name'
                            )
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpanFull(),

                        Textarea::make(
                            'excerpt'
                        )
                            ->label(
                                'Excerpt'
                            )
                            ->rows(4)
                            ->maxLength(
                                500
                            )
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(
                    'Content'
                )
                    ->schema([
                        RichEditor::make(
                            'content'
                        )
                            ->label(
                                'Content'
                            )
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make(
                    'Featured Image'
                )
                    ->schema([
                        FileUpload::make(
                            'featured_image'
                        )
                            ->label(
                                'Featured Image'
                            )
                            ->image()
                            ->disk(
                                'public'
                            )
                            ->directory(
                                'blog'
                            )
                            ->visibility(
                                'public'
                            )
                            ->imageEditor()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make(
                    'Publishing'
                )
                    ->schema([
                        TextInput::make(
                            'author'
                        )
                            ->label(
                                'Author'
                            )
                            ->maxLength(
                                255
                            ),

                        DatePicker::make(
                            'published_date'
                        )
                            ->label(
                                'Published Date'
                            )
                            ->native(false),

                        TextInput::make(
                            'read_time'
                        )
                            ->label(
                                'Read Time'
                            )
                            ->numeric()
                            ->minValue(
                                1
                            )
                            ->suffix(
                                'min'
                            )
                            ->default(
                                5
                            ),

                        Toggle::make(
                            'published'
                        )
                            ->label(
                                'Published'
                            )
                            ->default(
                                false
                            ),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(
                    'SEO'
                )
                    ->schema([
                        TextInput::make(
                            'seo_title'
                        )
                            ->label(
                                'SEO Title'
                            )
                            ->maxLength(
                                70
                            )
                            ->columnSpanFull(),

                        Textarea::make(
                            'seo_description'
                        )
                            ->label(
                                'SEO Description'
                            )
                            ->rows(3)
                            ->maxLength(
                                170
                            )
                            ->columnSpanFull(),

                        FileUpload::make('seo_social_image')
                            ->label('Social Image')
                            ->image()
                            ->disk('public')
                            ->directory('seo/blog')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function blogSlug(): string
    {
        $slug =
            Str::slug(
                (string) (
                    Setting::query()
                        ->where(
                            'key',
                            'blog_slug'
                        )
                        ->value(
                            'value'
                        )
                    ?: 'blog'
                )
            );

        return $slug
            ?: 'blog';
    }
}
