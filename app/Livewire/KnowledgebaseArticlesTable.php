<?php

namespace App\Livewire;

use App\Filament\Resources\KnowledgebaseArticles\KnowledgebaseArticleResource;
use App\Filament\Resources\KnowledgebaseArticles\Tables\KnowledgebaseArticlesTable as TableConfiguration;
use App\Models\KnowledgebaseArticle;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class KnowledgebaseArticlesTable extends Component implements
    HasTable,
    HasSchemas,
    HasActions
{
    use InteractsWithTable;
    use InteractsWithSchemas;
    use InteractsWithActions;

    public function table(
        Table $table
    ): Table {
        return TableConfiguration::configure(
            $table
        )
            ->query(
                KnowledgebaseArticle::query()
                    ->with(
                        'category'
                    )
            )
            ->recordActions([
                EditAction::make()
                    ->url(
                        fn (
                            KnowledgebaseArticle $record
                        ): string =>
                            KnowledgebaseArticleResource::getUrl(
                                'edit',
                                [
                                    'record' =>
                                        $record,
                                ]
                            )
                    ),
            ]);
    }

    public function render(): View
    {
        return view(
            'livewire.knowledgebase-articles-table'
        );
    }
}