<?php

namespace App\Filament\Resources\KnowledgebaseArticles\Pages;

use App\Filament\Resources\KnowledgebaseArticles\KnowledgebaseArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKnowledgebaseArticle extends CreateRecord
{
    protected static string $resource =
        KnowledgebaseArticleResource::class;
}