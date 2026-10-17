<?php

namespace App\Filament\Pages;

use App\Filament\Resources\KnowledgebaseArticles\KnowledgebaseArticleResource;
use App\Filament\Resources\KnowledgebaseCategories\KnowledgebaseCategoryResource;
use App\Models\Page as SitePage;
use App\Models\PageCategory;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use UnitEnum;

class Knowledgebase extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup =
        'Content';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-book-open';

    protected static ?string $navigationLabel =
        'Knowledgebase';

    protected static ?string $title =
        'Knowledgebase';

    protected static ?int $navigationSort =
        2;

    protected string $view =
        'filament.pages.knowledgebase';

    public ?array $data = [];

    public function mount(): void
    {
        $settings =
            Setting::query()
                ->where(
                    'group',
                    'knowledgebase'
                )
                ->pluck(
                    'value',
                    'key'
                );

        $configuredSlug =
            Str::slug(
                (string) $settings->get(
                    'knowledgebase_slug',
                    'knowledgebase'
                )
            );

        if (!$configuredSlug) {
            $configuredSlug =
                'knowledgebase';
        }

        $page =
            $this->findKnowledgebasePage(
                $settings->get(
                    'knowledgebase_page_id'
                ),
                $configuredSlug
            );

        $this->form->fill([
            'knowledgebase_page_title' =>
                $settings->get(
                    'knowledgebase_page_title'
                )
                ?: $page?->title
                ?: 'Knowledgebase',

            'knowledgebase_slug' =>
                $settings->get(
                    'knowledgebase_slug'
                )
                ?: $page?->slug
                ?: 'knowledgebase',

            'knowledgebase_description' =>
                $settings->get(
                    'knowledgebase_description'
                )
                ?: $page?->short_description
                ?: '',

            'knowledgebase_category_id' =>
                $settings->get(
                    'knowledgebase_category_id'
                )
                ?: $page?->category_id,

            'knowledgebase_sort_order' =>
                (int) (
                    $settings->get(
                        'knowledgebase_sort_order'
                    )
                    ?? $page?->sort_order
                    ?? 0
                ),

            'knowledgebase_active' =>
                $this->boolean(
                    $settings->get(
                        'knowledgebase_active',
                        $page?->active
                            ?? true
                    )
                ),

            'knowledgebase_show_in_header' =>
                $this->boolean(
                    $settings->get(
                        'knowledgebase_show_in_header',
                        $page?->show_in_header
                            ?? false
                    )
                ),

            'knowledgebase_show_in_footer' =>
                $this->boolean(
                    $settings->get(
                        'knowledgebase_show_in_footer',
                        $page?->show_in_footer
                            ?? false
                    )
                ),

            'knowledgebase_hero_enabled' =>
                $this->boolean(
                    $settings->get(
                        'knowledgebase_hero_enabled',
                        true
                    )
                ),

            'knowledgebase_hero_alignment' =>
                $settings->get(
                    'knowledgebase_hero_alignment',
                    'center'
                ),

            'knowledgebase_hero_eyebrow' =>
                $settings->get(
                    'knowledgebase_hero_eyebrow'
                )
                ?: 'Support',

            'knowledgebase_hero_heading' =>
                $settings->get(
                    'knowledgebase_hero_heading'
                )
                ?: 'How can we help?',

            'knowledgebase_hero_description' =>
                $settings->get(
                    'knowledgebase_hero_description'
                )
                ?: 'Browse guides, documentation, and answers to common questions.',

            'knowledgebase_hero_background_image' =>
                $settings->get(
                    'knowledgebase_hero_background_image'
                ),

            'knowledgebase_seo_title' =>
                $settings->get(
                    'knowledgebase_seo_title'
                )
                ?: '',

            'knowledgebase_seo_description' =>
                $settings->get(
                    'knowledgebase_seo_description'
                )
                ?: '',
        ]);
    }

    public function form(
        Schema $schema
    ): Schema {
        return $schema
            ->statePath(
                'data'
            )
            ->columns(1)
            ->components([
                Section::make(
                    'General'
                )
                    ->schema([
                        TextInput::make(
                            'knowledgebase_page_title'
                        )
                            ->label(
                                'Page Title'
                            )
                            ->required()
                            ->maxLength(255),

                        TextInput::make(
                            'knowledgebase_slug'
                        )
                            ->label(
                                'Slug'
                            )
                            ->required()
                            ->prefix('/')
                            ->maxLength(255)
                            ->dehydrateStateUsing(
                                fn (
                                    ?string $state
                                ): string =>
                                    Str::slug(
                                        $state
                                        ?? 'knowledgebase'
                                    )
                            ),

                        Textarea::make(
                            'knowledgebase_description'
                        )
                            ->label(
                                'Description'
                            )
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Select::make(
                            'knowledgebase_category_id'
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
                                'Standalone'
                            ),

                        TextInput::make(
                            'knowledgebase_sort_order'
                        )
                            ->label(
                                'Sort Order'
                            )
                            ->numeric()
                            ->default(0),

                        Toggle::make(
                            'knowledgebase_active'
                        )
                            ->label(
                                'Active'
                            )
                            ->default(true),

                        Toggle::make(
                            'knowledgebase_show_in_header'
                        )
                            ->label(
                                'Show in Header'
                            )
                            ->default(false),

                        Toggle::make(
                            'knowledgebase_show_in_footer'
                        )
                            ->label(
                                'Show in Footer'
                            )
                            ->default(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(
                    'Hero'
                )
                    ->schema([
                        Toggle::make(
                            'knowledgebase_hero_enabled'
                        )
                            ->label(
                                'Hero Enabled'
                            )
                            ->default(true)
                            ->live(),

                        Select::make(
                            'knowledgebase_hero_alignment'
                        )
                            ->label(
                                'Hero Alignment'
                            )
                            ->options([
                                'left' =>
                                    'Left',

                                'center' =>
                                    'Center',
                            ])
                            ->default(
                                'center'
                            )
                            ->required()
                            ->native(false),

                        TextInput::make(
                            'knowledgebase_hero_eyebrow'
                        )
                            ->label(
                                'Eyebrow / Badge'
                            )
                            ->maxLength(120)
                            ->columnSpanFull(),

                        TextInput::make(
                            'knowledgebase_hero_heading'
                        )
                            ->label(
                                'Heading'
                            )
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make(
                            'knowledgebase_hero_description'
                        )
                            ->label(
                                'Subheading / Description'
                            )
                            ->rows(3)
                            ->maxLength(700)
                            ->columnSpanFull(),

                        FileUpload::make(
                            'knowledgebase_hero_background_image'
                        )
                            ->label(
                                'Background Image'
                            )
                            ->image()
                            ->disk(
                                'public'
                            )
                            ->directory(
                                'knowledgebase/page'
                            )
                            ->visibility(
                                'public'
                            )
                            ->imageEditor()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(
                    'SEO'
                )
                    ->schema([
                        TextInput::make(
                            'knowledgebase_seo_title'
                        )
                            ->label(
                                'SEO Title'
                            )
                            ->maxLength(70)
                            ->columnSpanFull(),

                        Textarea::make(
                            'knowledgebase_seo_description'
                        )
                            ->label(
                                'Meta Description'
                            )
                            ->rows(3)
                            ->maxLength(170)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        $data =
            $this->form
                ->getState();

        $slug =
            Str::slug(
                (string) (
                    $data[
                        'knowledgebase_slug'
                    ]
                    ?? 'knowledgebase'
                )
            );

        if (!$slug) {
            $slug =
                'knowledgebase';
        }

        $settings =
            Setting::query()
                ->where(
                    'group',
                    'knowledgebase'
                )
                ->pluck(
                    'value',
                    'key'
                );

        $page =
            $this->findKnowledgebasePage(
                $settings->get(
                    'knowledgebase_page_id'
                ),
                (string) $settings->get(
                    'knowledgebase_slug',
                    'knowledgebase'
                )
            );

        $conflict =
            SitePage::query()
                ->where(
                    'slug',
                    $slug
                )
                ->when(
                    $page,
                    fn ($query) =>
                        $query->where(
                            'id',
                            '!=',
                            $page->id
                        )
                )
                ->exists();

        if ($conflict) {
            Notification::make()
                ->title(
                    'Slug already in use'
                )
                ->body(
                    'Choose another Knowledgebase page slug.'
                )
                ->danger()
                ->send();

            return;
        }

        $page ??=
            new SitePage();

        $page->fill([
            'category_id' =>
                filled(
                    $data[
                        'knowledgebase_category_id'
                    ]
                    ?? null
                )
                    ? (int) $data[
                        'knowledgebase_category_id'
                    ]
                    : null,

            'title' =>
                (string) (
                    $data[
                        'knowledgebase_page_title'
                    ]
                    ?? 'Knowledgebase'
                ),

            'slug' =>
                $slug,

            'template' =>
                'knowledgebase',

            'page_type' =>
                SitePage::TYPE_STRUCTURED,

            'short_description' =>
                $data[
                    'knowledgebase_description'
                ]
                ?? null,

            'content' =>
                null,

            'sections' =>
                null,

            'document_layout' =>
                SitePage::DOCUMENT_LAYOUT_LEFT,

            'document_updated_at' =>
                null,

            'external_url' =>
                null,

            'open_new_tab' =>
                false,

            'active' =>
                (bool) (
                    $data[
                        'knowledgebase_active'
                    ]
                    ?? true
                ),

            'show_in_header' =>
                (bool) (
                    $data[
                        'knowledgebase_show_in_header'
                    ]
                    ?? false
                ),

            'show_in_footer' =>
                (bool) (
                    $data[
                        'knowledgebase_show_in_footer'
                    ]
                    ?? false
                ),

            'sort_order' =>
                (int) (
                    $data[
                        'knowledgebase_sort_order'
                    ]
                    ?? 0
                ),

            'published' =>
                (bool) (
                    $data[
                        'knowledgebase_active'
                    ]
                    ?? true
                ),

            'system_page' =>
                true,
        ]);

        $page->save();

        $heroImage =
            $data[
                'knowledgebase_hero_background_image'
            ]
            ?? null;

        if (
            is_array(
                $heroImage
            )
        ) {
            $heroImage =
                collect(
                    $heroImage
                )
                    ->filter()
                    ->first();
        }

        $values = [
            'knowledgebase_page_id' =>
                $page->id,

            'knowledgebase_page_title' =>
                $page->title,

            'knowledgebase_slug' =>
                $slug,

            'knowledgebase_description' =>
                $data[
                    'knowledgebase_description'
                ]
                ?? '',

            'knowledgebase_category_id' =>
                $data[
                    'knowledgebase_category_id'
                ]
                ?? '',

            'knowledgebase_sort_order' =>
                (int) (
                    $data[
                        'knowledgebase_sort_order'
                    ]
                    ?? 0
                ),

            'knowledgebase_active' =>
                (bool) (
                    $data[
                        'knowledgebase_active'
                    ]
                    ?? true
                ),

            'knowledgebase_show_in_header' =>
                (bool) (
                    $data[
                        'knowledgebase_show_in_header'
                    ]
                    ?? false
                ),

            'knowledgebase_show_in_footer' =>
                (bool) (
                    $data[
                        'knowledgebase_show_in_footer'
                    ]
                    ?? false
                ),

            'knowledgebase_hero_enabled' =>
                (bool) (
                    $data[
                        'knowledgebase_hero_enabled'
                    ]
                    ?? true
                ),

            'knowledgebase_hero_alignment' =>
                $data[
                    'knowledgebase_hero_alignment'
                ]
                ?? 'center',

            'knowledgebase_hero_eyebrow' =>
                $data[
                    'knowledgebase_hero_eyebrow'
                ]
                ?? '',

            'knowledgebase_hero_heading' =>
                $data[
                    'knowledgebase_hero_heading'
                ]
                ?? '',

            'knowledgebase_hero_description' =>
                $data[
                    'knowledgebase_hero_description'
                ]
                ?? '',

            'knowledgebase_hero_background_image' =>
                $heroImage
                ?? '',

            'knowledgebase_seo_title' =>
                $data[
                    'knowledgebase_seo_title'
                ]
                ?? '',

            'knowledgebase_seo_description' =>
                $data[
                    'knowledgebase_seo_description'
                ]
                ?? '',
        ];

        foreach (
            $values
            as $key => $value
        ) {
            $type =
                match ($key) {
                    'knowledgebase_hero_background_image' =>
                        'image',

                    'knowledgebase_active',
                    'knowledgebase_show_in_header',
                    'knowledgebase_show_in_footer',
                    'knowledgebase_hero_enabled' =>
                        'boolean',

                    'knowledgebase_sort_order',
                    'knowledgebase_page_id',
                    'knowledgebase_category_id' =>
                        'number',

                    default =>
                        'text',
                };

            $this->saveSetting(
                $key,
                $value,
                $type
            );
        }

        $this->data[
            'knowledgebase_slug'
        ] = $slug;

        Notification::make()
            ->title(
                'Knowledgebase settings saved'
            )
            ->success()
            ->send();
    }

    public function getCreateArticleUrl(): string
    {
        return KnowledgebaseArticleResource::getUrl(
            'create'
        );
    }

    public function getArticlesUrl(): string
    {
        return KnowledgebaseArticleResource::getUrl(
            'index'
        );
    }

    public function getCreateCategoryUrl(): string
    {
        return KnowledgebaseCategoryResource::getUrl(
            'create'
        );
    }

    public function getCategoriesUrl(): string
    {
        return KnowledgebaseCategoryResource::getUrl(
            'index'
        );
    }

    private function findKnowledgebasePage(
        mixed $pageId,
        string $slug
    ): ?SitePage {
        if (
            filled(
                $pageId
            )
        ) {
            $page =
                SitePage::query()
                    ->find(
                        (int) $pageId
                    );

            if ($page) {
                return $page;
            }
        }

        $page =
            SitePage::query()
                ->where(
                    'template',
                    'knowledgebase'
                )
                ->first();

        if ($page) {
            return $page;
        }

        return SitePage::query()
            ->where(
                'slug',
                Str::slug(
                    $slug
                )
            )
            ->first();
    }

    private function saveSetting(
        string $key,
        mixed $value,
        string $type
    ): void {
        if (
            is_bool(
                $value
            )
        ) {
            $value =
                $value
                    ? '1'
                    : '0';
        }

        Setting::updateOrCreate(
            [
                'key' =>
                    $key,
            ],
            [
                'value' =>
                    (string) (
                        $value
                        ?? ''
                    ),

                'type' =>
                    $type,

                'group' =>
                    'knowledgebase',
            ]
        );
    }

    private function boolean(
        mixed $value
    ): bool {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
        );
    }
}