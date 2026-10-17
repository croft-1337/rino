<?php

namespace App\Filament\Resources\KnowledgebaseCategories\Pages;

use App\Filament\Resources\KnowledgebaseCategories\KnowledgebaseCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKnowledgebaseCategory extends CreateRecord
{
    protected static string $resource =
        KnowledgebaseCategoryResource::class;
}