<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Page;
use App\Models\PageCategory;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(
        Schema $schema
    ): Schema {
        return $schema
            ->components([

                Tabs::make('Page Editor')
                    ->tabs([

                        Tab::make('General')
                            ->icon(
                                'heroicon-o-cog-6-tooth'
                            )
                            ->schema([

                                Section::make('Entry Type')
                                    ->description(
                                        'Choose how this website entry should behave.'
                                    )
                                    ->schema([

                                        Select::make('page_type')
                                            ->label('Type')
                                            ->options([
                                                Page::TYPE_STRUCTURED =>
                                                    'Structured Page',

                                                Page::TYPE_DOCUMENT =>
                                                    'Document',

                                                Page::TYPE_EXTERNAL =>
                                                    'External Link',
                                            ])
                                            ->default(
                                                Page::TYPE_STRUCTURED
                                            )
                                            ->required()
                                            ->native(false)
                                            ->live(),

                                    ]),

                                Section::make('General')
                                    ->schema([

                                        TextInput::make('title')
                                            ->label(
                                                fn (
                                                    Get $get
                                                ): string =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        ===
                                                    Page::TYPE_EXTERNAL
                                                        ? 'Label'
                                                        : 'Page Title'
                                            )
                                            ->placeholder(
                                                fn (
                                                    Get $get
                                                ): string =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        ===
                                                    Page::TYPE_EXTERNAL
                                                        ? 'Status Page'
                                                        : 'Hytale Hosting'
                                            )
                                            ->required()
                                            ->maxLength(255)
                                            ->live(
                                                onBlur: true
                                            )
                                            ->afterStateUpdated(
                                                function (
                                                    ?string $state,
                                                    Set $set,
                                                    Get $get
                                                ): void {
                                                    if (!$state) {
                                                        return;
                                                    }

                                                    if (
                                                        $get(
                                                            'page_type'
                                                        )
                                                        ===
                                                        Page::TYPE_EXTERNAL
                                                    ) {
                                                        return;
                                                    }

                                                    if (
                                                        !$get(
                                                            'slug'
                                                        )
                                                    ) {
                                                        $set(
                                                            'slug',
                                                            Str::slug(
                                                                $state
                                                            )
                                                        );
                                                    }
                                                }
                                            ),

                                        Select::make(
                                            'category_id'
                                        )
                                            ->label(
                                                'Category'
                                            )
                                            ->options(
                                                fn (): array =>
                                                    PageCategory::query()
                                                        ->orderBy(
                                                            'sort_order'
                                                        )
                                                        ->orderBy(
                                                            'name'
                                                        )
                                                        ->pluck(
                                                            'name',
                                                            'id'
                                                        )
                                                        ->all()
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->placeholder(
                                                'None / Standalone'
                                            ),

                                        TextInput::make(
                                            'slug'
                                        )
                                            ->label(
                                                'URL Slug'
                                            )
                                            ->placeholder(
                                                'hytale-hosting'
                                            )
                                            ->prefix('/')
                                            ->required(
                                                fn (
                                                    Get $get
                                                ): bool =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        !==
                                                    Page::TYPE_EXTERNAL
                                            )
                                            ->visible(
                                                fn (
                                                    Get $get
                                                ): bool =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        !==
                                                    Page::TYPE_EXTERNAL
                                            )
                                            ->unique(
                                                table: 'pages',
                                                column: 'slug',
                                                ignoreRecord: true
                                            )
                                            ->maxLength(255)
                                            ->helperText(
                                                'Lowercase letters, numbers and dashes only.'
                                            )
                                            ->live(
                                                onBlur: true
                                            )
                                            ->dehydrateStateUsing(
                                                fn (
                                                    ?string $state
                                                ): ?string =>
                                                    filled(
                                                        $state
                                                    )
                                                        ? Str::slug(
                                                            $state
                                                        )
                                                        : null
                                            ),

                                        Placeholder::make(
                                            'page_url'
                                        )
                                            ->label(
                                                'Public URL'
                                            )
                                            ->content(
                                                function (
                                                    Get $get
                                                ): string {
                                                    if (
                                                        $get(
                                                            'page_type'
                                                        )
                                                        ===
                                                        Page::TYPE_EXTERNAL
                                                    ) {
                                                        return $get(
                                                            'external_url'
                                                        )
                                                            ?:
                                                            'External URL not set';
                                                    }

                                                    $slug =
                                                        $get(
                                                            'slug'
                                                        );

                                                    if (!$slug) {
                                                        return '/';
                                                    }

                                                    return '/'
                                                        .
                                                        ltrim(
                                                            $slug,
                                                            '/'
                                                        );
                                                }
                                            ),

                                        Textarea::make(
                                            'short_description'
                                        )
                                            ->label(
                                                'Short Description'
                                            )
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->visible(
                                                fn (
                                                    Get $get
                                                ): bool =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        !==
                                                    Page::TYPE_EXTERNAL
                                            )
                                            ->columnSpanFull(),

                                    ])
                                    ->columns(2),

                                Section::make(
                                    'Document Settings'
                                )
                                    ->description(
                                        'Configure the presentation of this document.'
                                    )
                                    ->schema([

                                        Select::make(
                                            'document_layout'
                                        )
                                            ->label(
                                                'Layout'
                                            )
                                            ->options([
                                                Page::DOCUMENT_LAYOUT_LEFT =>
                                                    'Left',

                                                Page::DOCUMENT_LAYOUT_CENTERED =>
                                                    'Centered',
                                            ])
                                            ->default(
                                                Page::DOCUMENT_LAYOUT_LEFT
                                            )
                                            ->required()
                                            ->native(false),

                                        DatePicker::make(
                                            'document_updated_at'
                                        )
                                            ->label(
                                                'Last Updated'
                                            )
                                            ->native(false)
                                            ->displayFormat(
                                                'F j, Y'
                                            )
                                            ->helperText(
                                                'Optional. Leave empty to hide it.'
                                            ),

                                    ])
                                    ->columns(2)
                                    ->visible(
                                        fn (
                                            Get $get
                                        ): bool =>
                                            $get(
                                                'page_type'
                                            )
                                                ===
                                            Page::TYPE_DOCUMENT
                                    ),

                                Section::make(
                                    'Document Content'
                                )
                                    ->description(
                                        'Create and format the content displayed on this page.'
                                    )
                                    ->schema([

                                        RichEditor::make(
                                            'content'
                                        )
                                            ->label(
                                                'Page Content'
                                            )
                                            ->required(
                                                fn (
                                                    Get $get
                                                ): bool =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        ===
                                                    Page::TYPE_DOCUMENT
                                            )
                                            ->columnSpanFull(),

                                    ])
                                    ->visible(
                                        fn (
                                            Get $get
                                        ): bool =>
                                            $get(
                                                'page_type'
                                            )
                                                ===
                                            Page::TYPE_DOCUMENT
                                    ),

                                Section::make(
                                    'External Destination'
                                )
                                    ->description(
                                        'Configure the destination for this entry.'
                                    )
                                    ->schema([

                                        TextInput::make(
                                            'external_url'
                                        )
                                            ->label('URL')
                                            ->placeholder(
                                                'https://example.com'
                                            )
                                            ->url()
                                            ->required(
                                                fn (
                                                    Get $get
                                                ): bool =>
                                                    $get(
                                                        'page_type'
                                                    )
                                                        ===
                                                    Page::TYPE_EXTERNAL
                                            )
                                            ->live(
                                                onBlur: true
                                            )
                                            ->columnSpanFull(),

                                        Toggle::make(
                                            'open_new_tab'
                                        )
                                            ->label(
                                                'Open in New Tab'
                                            )
                                            ->default(true),

                                    ])
                                    ->visible(
                                        fn (
                                            Get $get
                                        ): bool =>
                                            $get(
                                                'page_type'
                                            )
                                                ===
                                            Page::TYPE_EXTERNAL
                                    ),

                                Section::make(
                                    'Visibility'
                                )
                                    ->description(
                                        'Control whether this entry is enabled and where it appears.'
                                    )
                                    ->schema([

                                        Toggle::make(
                                            'active'
                                        )
                                            ->label(
                                                'Active'
                                            )
                                            ->helperText(
                                                'When disabled, this entry is hidden and unavailable.'
                                            )
                                            ->default(true),

                                        Toggle::make(
                                            'show_in_header'
                                        )
                                            ->label(
                                                'Show in Header'
                                            )
                                            ->default(false),

                                        Toggle::make(
                                            'show_in_footer'
                                        )
                                            ->label(
                                                'Show in Footer'
                                            )
                                            ->default(false),

                                        TextInput::make(
                                            'sort_order'
                                        )
                                            ->label(
                                                'Sort Order'
                                            )
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0),

                                    ])
                                    ->columns(2),

                            ]),

                        Tab::make(
                            'Page Sections'
                        )
                            ->icon(
                                'heroicon-o-rectangle-stack'
                            )
                            ->visible(
                                fn (
                                    Get $get
                                ): bool =>
                                    $get(
                                        'page_type'
                                    )
                                        ===
                                    Page::TYPE_STRUCTURED
                            )
                            ->schema([

                                Builder::make(
                                    'sections'
                                )
                                    ->label('')
                                    ->blocks(
                                        PageSections::blocks()
                                    )
                                    ->addActionLabel(
                                        'Add Section'
                                    )
                                    ->collapsible()
                                    ->collapsed()
                                    ->cloneable()
                                    ->blockNumbers(false)
                                    ->columnSpanFull(),

                            ]),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}