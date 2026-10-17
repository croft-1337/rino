<?php

namespace App\Filament\Resources\KnowledgebaseArticles\Pages;

use App\Filament\Resources\KnowledgebaseArticles\KnowledgebaseArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKnowledgebaseArticles extends ListRecords
{
    protected static string $resource =
        KnowledgebaseArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Article'),
        ];
    }
}