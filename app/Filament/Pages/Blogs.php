<?php



namespace App\Filament\Pages;



use App\Filament\Resources\BlogPosts\BlogPostResource;

use App\Filament\Resources\BlogPosts\Tables\BlogPostsTable;

use App\Models\BlogPost;

use App\Models\Page as SitePage;

use App\Models\PageCategory;

use App\Models\Setting;

use BackedEnum;

use Filament\Actions\Action;

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

use Filament\Tables\Concerns\InteractsWithTable;

use Filament\Tables\Contracts\HasTable;

use Filament\Tables\Table;

use Illuminate\Support\Str;

use UnitEnum;



class Blogs extends Page implements HasSchemas, HasTable

{

    use InteractsWithSchemas;

    use InteractsWithTable;



    protected static string|UnitEnum|null $navigationGroup =

        'Content';



    protected static string|BackedEnum|null $navigationIcon =

        'heroicon-o-document-text';



    protected static ?string $navigationLabel =

        'Blogs';



    protected static ?string $title =

        'Blogs';



    protected static ?int $navigationSort =

        1;



    protected string $view =

        'filament.pages.blogs';



    public ?array $data = [];



    public function mount(): void

    {

        $settings =

            Setting::query()

                ->where(

                    'group',

                    'blog'

                )

                ->pluck(

                    'value',

                    'key'

                );



        $configuredSlug =

            Str::slug(

                (string) $settings->get(

                    'blog_slug',

                    'blog'

                )

            );



        if (!$configuredSlug) {

            $configuredSlug = 'blog';

        }



        $blogPage =

            $this->findBlogPage(

                $settings->get(

                    'blog_page_id'

                ),

                $configuredSlug

            );



        $this->form->fill([

            'blog_page_title' =>

                $settings->get(

                    'blog_page_title'

                )

                ?: $blogPage?->title

                ?: 'Blog',



            'blog_slug' =>

                $settings->get(

                    'blog_slug'

                )

                ?: $blogPage?->slug

                ?: 'blog',



            'blog_description' =>

                $settings->get(

                    'blog_description'

                )

                ?: $blogPage?->short_description

                ?: '',



            'blog_category_id' =>

                $settings->get(

                    'blog_category_id'

                )

                ?: $blogPage?->category_id,



            'blog_active' =>

                $this->boolean(

                    $settings->get(

                        'blog_active',

                        $blogPage?->active

                            ?? true

                    )

                ),



            'blog_show_in_header' =>

                $this->boolean(

                    $settings->get(

                        'blog_show_in_header',

                        $blogPage?->show_in_header

                            ?? false

                    )

                ),



            'blog_show_in_footer' =>

                $this->boolean(

                    $settings->get(

                        'blog_show_in_footer',

                        $blogPage?->show_in_footer

                            ?? false

                    )

                ),



            'blog_sort_order' =>

                (int) (

                    $settings->get(

                        'blog_sort_order'

                    )

                    ?? $blogPage?->sort_order

                    ?? 0

                ),



            'blog_hero_enabled' =>

                $this->boolean(

                    $settings->get(

                        'blog_hero_enabled',

                        true

                    )

                ),



            'blog_hero_eyebrow' =>

                $settings->get(

                    'blog_hero_eyebrow'

                )

                ?: 'Resources',



            'blog_hero_heading' =>

                $settings->get(

                    'blog_hero_heading'

                )

                ?: 'Insights, guides & updates',



            'blog_hero_description' =>

                $settings->get(

                    'blog_hero_description'

                )

                ?: '',



            'blog_hero_background_image' =>

                $settings->get(

                    'blog_hero_background_image'

                ),



            'blog_hero_alignment' =>

                $settings->get(

                    'blog_hero_alignment',

                    'left'

                ),



            'blog_seo_title' =>

                $settings->get(

                    'blog_seo_title'

                )

                ?: '',



            'blog_seo_description' =>

                $settings->get(

                    'blog_seo_description'

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

                            'blog_page_title'

                        )

                            ->label(

                                'Page Title'

                            )

                            ->required()

                            ->maxLength(

                                255

                            ),



                        TextInput::make(

                            'blog_slug'

                        )

                            ->label(

                                'Slug'

                            )

                            ->required()

                            ->prefix('/')

                            ->maxLength(

                                255

                            )

                            ->dehydrateStateUsing(

                                fn (

                                    ?string $state

                                ): string =>

                                    Str::slug(

                                        $state

                                        ?? 'blog'

                                    )

                            ),



                        Textarea::make(

                            'blog_description'

                        )

                            ->label(

                                'Description'

                            )

                            ->rows(3)

                            ->maxLength(

                                500

                            )

                            ->columnSpanFull(),



                        Select::make(

                            'blog_category_id'

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

                            'blog_sort_order'

                        )

                            ->label(

                                'Sort Order'

                            )

                            ->numeric()

                            ->default(0),



                        Toggle::make(

                            'blog_active'

                        )

                            ->label(

                                'Active'

                            )

                            ->default(true),



                        Toggle::make(

                            'blog_show_in_header'

                        )

                            ->label(

                                'Show in Header'

                            )

                            ->default(false),



                        Toggle::make(

                            'blog_show_in_footer'

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

                            'blog_hero_enabled'

                        )

                            ->label(

                                'Hero Enabled'

                            )

                            ->default(true)

                            ->live(),



                        Select::make(

                            'blog_hero_alignment'

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

                                'left'

                            )

                            ->required()

                            ->native(false),



                        TextInput::make(

                            'blog_hero_eyebrow'

                        )

                            ->label(

                                'Eyebrow / Badge'

                            )

                            ->maxLength(

                                120

                            )

                            ->columnSpanFull(),



                        TextInput::make(

                            'blog_hero_heading'

                        )

                            ->label(

                                'Heading'

                            )

                            ->maxLength(

                                255

                            )

                            ->columnSpanFull(),



                        Textarea::make(

                            'blog_hero_description'

                        )

                            ->label(

                                'Subheading / Description'

                            )

                            ->rows(3)

                            ->maxLength(

                                700

                            )

                            ->columnSpanFull(),



                        FileUpload::make(

                            'blog_hero_background_image'

                        )

                            ->label(

                                'Background Image'

                            )

                            ->image()

                            ->disk(

                                'public'

                            )

                            ->directory(

                                'blog/page'

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

                            'blog_seo_title'

                        )

                            ->label(

                                'SEO Title'

                            )

                            ->maxLength(

                                70

                            )

                            ->columnSpanFull(),



                        Textarea::make(

                            'blog_seo_description'

                        )

                            ->label(

                                'Meta Description'

                            )

                            ->rows(3)

                            ->maxLength(

                                170

                            )

                            ->columnSpanFull(),

                    ])

                    ->columnSpanFull(),

            ]);

    }



    public function table(

        Table $table

    ): Table {

        return BlogPostsTable::configure(

            $table

        )

            ->query(

                BlogPost::query()

                    ->with([

                        'tags',

                    ])

            )

            ->heading(

                'Blog Posts'

            )

            ->description(

                'Create and manage individual blog articles.'

            )

            ->toolbarActions([

                Action::make(

                    'create'

                )

                    ->label(

                        'New Blog Post'

                    )

                    ->icon(

                        'heroicon-o-plus'

                    )

                    ->url(

                        BlogPostResource::getUrl(

                            'create'

                        )

                    ),

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

                        'blog_slug'

                    ]

                    ?? 'blog'

                )

            );



        if (!$slug) {

            $slug =

                'blog';

        }



        $settings =

            Setting::query()

                ->where(

                    'group',

                    'blog'

                )

                ->pluck(

                    'value',

                    'key'

                );



        $blogPage =

            $this->findBlogPage(

                $settings->get(

                    'blog_page_id'

                ),

                (string) $settings->get(

                    'blog_slug',

                    'blog'

                )

            );



        $conflict =

            SitePage::query()

                ->where(

                    'slug',

                    $slug

                )

                ->when(

                    $blogPage,

                    fn ($query) =>

                        $query->where(

                            'id',

                            '!=',

                            $blogPage->id

                        )

                )

                ->exists();



        if ($conflict) {

            Notification::make()

                ->title(

                    'Slug already in use'

                )

                ->body(

                    'Choose another Blog page slug.'

                )

                ->danger()

                ->send();



            return;

        }



        $blogPage ??=

            new SitePage();



        $blogPage->fill([

            'category_id' =>

                filled(

                    $data[

                        'blog_category_id'

                    ]

                    ?? null

                )

                    ? (int) $data[

                        'blog_category_id'

                    ]

                    : null,



            'title' =>

                (string) (

                    $data[

                        'blog_page_title'

                    ]

                    ?? 'Blog'

                ),



            'slug' =>

                $slug,



            'template' =>

                'blog',



            'page_type' =>

                SitePage::TYPE_STRUCTURED,



            'short_description' =>

                $data[

                    'blog_description'

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

                        'blog_active'

                    ]

                    ?? true

                ),



            'show_in_header' =>

                (bool) (

                    $data[

                        'blog_show_in_header'

                    ]

                    ?? false

                ),



            'show_in_footer' =>

                (bool) (

                    $data[

                        'blog_show_in_footer'

                    ]

                    ?? false

                ),



            'sort_order' =>

                (int) (

                    $data[

                        'blog_sort_order'

                    ]

                    ?? 0

                ),



            'published' =>

                (bool) (

                    $data[

                        'blog_active'

                    ]

                    ?? true

                ),



            'system_page' =>

                true,

        ]);



        $blogPage->save();



        $heroImage =

            $data[

                'blog_hero_background_image'

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

            'blog_page_id' =>

                $blogPage->id,



            'blog_page_title' =>

                $blogPage->title,



            'blog_slug' =>

                $slug,



            'blog_description' =>

                $data[

                    'blog_description'

                ]

                ?? '',



            'blog_category_id' =>

                $data[

                    'blog_category_id'

                ]

                ?? '',



            'blog_active' =>

                (bool) (

                    $data[

                        'blog_active'

                    ]

                    ?? true

                ),



            'blog_show_in_header' =>

                (bool) (

                    $data[

                        'blog_show_in_header'

                    ]

                    ?? false

                ),



            'blog_show_in_footer' =>

                (bool) (

                    $data[

                        'blog_show_in_footer'

                    ]

                    ?? false

                ),



            'blog_sort_order' =>

                (int) (

                    $data[

                        'blog_sort_order'

                    ]

                    ?? 0

                ),



            'blog_hero_enabled' =>

                (bool) (

                    $data[

                        'blog_hero_enabled'

                    ]

                    ?? true

                ),



            'blog_hero_eyebrow' =>

                $data[

                    'blog_hero_eyebrow'

                ]

                ?? '',



            'blog_hero_heading' =>

                $data[

                    'blog_hero_heading'

                ]

                ?? '',



            'blog_hero_description' =>

                $data[

                    'blog_hero_description'

                ]

                ?? '',



            'blog_hero_background_image' =>

                $heroImage

                ?? '',



            'blog_hero_alignment' =>

                $data[

                    'blog_hero_alignment'

                ]

                ?? 'left',



            'blog_seo_title' =>

                $data[

                    'blog_seo_title'

                ]

                ?? '',



            'blog_seo_description' =>

                $data[

                    'blog_seo_description'

                ]

                ?? '',

        ];



        foreach (

            $values

            as $key => $value

        ) {

            $type =

                match ($key) {

                    'blog_hero_background_image' =>

                        'image',



                    'blog_active',

                    'blog_show_in_header',

                    'blog_show_in_footer',

                    'blog_hero_enabled' =>

                        'boolean',



                    'blog_sort_order',

                    'blog_page_id',

                    'blog_category_id' =>

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

            'blog_slug'

        ] = $slug;



        Notification::make()

            ->title(

                'Blog settings saved'

            )

            ->success()

            ->send();

    }



    private function findBlogPage(

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

                    'blog'

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

                    'blog',

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