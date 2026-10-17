<?php

namespace App\Filament\Resources\KnowledgebaseCategories\Pages;

use App\Filament\Resources\KnowledgebaseCategories\KnowledgebaseCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKnowledgebaseCategories extends ListRecords
{
    protected static string $resource =
        KnowledgebaseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Category'),
        ];
    }
}