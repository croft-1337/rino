<?php

namespace App\Filament\Resources\KnowledgebaseCategories\Pages;

use App\Filament\Resources\KnowledgebaseCategories\KnowledgebaseCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgebaseCategory extends EditRecord
{
    protected static string $resource =
        KnowledgebaseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}