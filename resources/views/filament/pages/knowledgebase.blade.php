<x-filament-panels::page>
    <form
        wire:submit="save"
        class="space-y-6"
    >
        {{ $this->form }}

        <div>
            <x-filament::button
                type="submit"
            >
                Save Changes
            </x-filament::button>
        </div>
    </form>

    <div class="kb-stack">
        <section class="kb-panel">
            <div class="kb-panel-header">
                <div class="kb-panel-copy">
                    <h2 class="kb-panel-title">
                        Articles
                    </h2>

                    <p class="kb-panel-description">
                        Create and manage knowledgebase articles.
                    </p>
                </div>

                <div class="kb-panel-actions">
                    <x-filament::button
                        tag="a"
                        :href="$this->getCreateArticleUrl()"
                        icon="heroicon-o-plus"
                        size="sm"
                    >
                        New Article
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        :href="$this->getArticlesUrl()"
                        color="gray"
                        outlined
                        icon="heroicon-o-arrow-top-right-on-square"
                        size="sm"
                    >
                        Open Articles
                    </x-filament::button>
                </div>
            </div>

            <div class="kb-panel-table">
                @livewire(
                    'knowledgebase-articles-table'
                )
            </div>
        </section>

        <section class="kb-panel">
            <div class="kb-panel-header">
                <div class="kb-panel-copy">
                    <h2 class="kb-panel-title">
                        Categories
                    </h2>

                    <p class="kb-panel-description">
                        Organize knowledgebase articles into categories.
                    </p>
                </div>

                <div class="kb-panel-actions">
                    <x-filament::button
                        tag="a"
                        :href="$this->getCreateCategoryUrl()"
                        icon="heroicon-o-plus"
                        size="sm"
                    >
                        New Category
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        :href="$this->getCategoriesUrl()"
                        color="gray"
                        outlined
                        icon="heroicon-o-arrow-top-right-on-square"
                        size="sm"
                    >
                        Open Categories
                    </x-filament::button>
                </div>
            </div>

            <div class="kb-panel-table">
                @livewire(
                    'knowledgebase-categories-table'
                )
            </div>
        </section>
    </div>

    <style>
        .kb-stack {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .kb-panel {
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            background: rgb(24, 24, 27);
        }

        .kb-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .kb-panel-copy {
            min-width: 0;
        }

        .kb-panel-title {
            margin: 0;
            font-size: 1rem;
            line-height: 1.5rem;
            font-weight: 600;
            color: rgb(255, 255, 255);
        }

        .kb-panel-description {
            margin: 0.125rem 0 0;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: rgb(161, 161, 170);
        }

        .kb-panel-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .kb-panel-table {
            overflow: hidden;
        }

        .kb-panel-table .fi-ta-ctn {
            margin: 0 !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .kb-panel-table .fi-ta {
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .kb-panel-table .fi-ta-header {
            border-radius: 0 !important;
        }

        .kb-panel-table .fi-ta-content {
            border-radius: 0 !important;
        }

        .kb-panel-table .fi-ta-header-ctn {
            border-radius: 0 !important;
        }

        .kb-panel-table .fi-ta-table {
            border-radius: 0 !important;
        }

        @media (max-width: 639px) {
            .kb-panel-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .kb-panel-actions {
                width: 100%;
            }
        }

        html:not(.dark) .kb-panel {
            border-color: rgba(0, 0, 0, 0.08);
            background: rgb(255, 255, 255);
        }

        html:not(.dark) .kb-panel-header {
            border-bottom-color: rgba(0, 0, 0, 0.08);
        }

        html:not(.dark) .kb-panel-title {
            color: rgb(17, 24, 39);
        }

        html:not(.dark) .kb-panel-description {
            color: rgb(107, 114, 128);
        }
    </style>
</x-filament-panels::page>