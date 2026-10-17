<?php

namespace App\Filament\Resources\KnowledgebaseArticles\Pages;

use App\Filament\Resources\KnowledgebaseArticles\KnowledgebaseArticleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgebaseArticle extends EditRecord
{
    protected static string $resource =
        KnowledgebaseArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}