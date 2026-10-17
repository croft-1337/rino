<?php

namespace App\Filament\Resources\KnowledgebaseCategories;

use App\Filament\Resources\KnowledgebaseCategories\Pages\CreateKnowledgebaseCategory;
use App\Filament\Resources\KnowledgebaseCategories\Pages\EditKnowledgebaseCategory;
use App\Filament\Resources\KnowledgebaseCategories\Pages\ListKnowledgebaseCategories;
use App\Filament\Resources\KnowledgebaseCategories\Schemas\KnowledgebaseCategoryForm;
use App\Filament\Resources\KnowledgebaseCategories\Tables\KnowledgebaseCategoriesTable;
use App\Models\KnowledgebaseCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KnowledgebaseCategoryResource extends Resource
{
    protected static ?string $model =
        KnowledgebaseCategory::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedFolder;

    protected static ?string $recordTitleAttribute =
        'name';

    protected static ?string $modelLabel =
        'Category';

    protected static ?string $pluralModelLabel =
        'Categories';

    protected static bool $shouldRegisterNavigation =
        false;

    public static function form(
        Schema $schema
    ): Schema {
        return KnowledgebaseCategoryForm::configure(
            $schema
        );
    }

    public static function table(
        Table $table
    ): Table {
        return KnowledgebaseCategoriesTable::configure(
            $table
        );
    }

    public static function getPages(): array
    {
        return [
            'index' =>
                ListKnowledgebaseCategories::route('/'),

            'create' =>
                CreateKnowledgebaseCategory::route('/create'),

            'edit' =>
                EditKnowledgebaseCategory::route('/{record}/edit'),
        ];
    }
}