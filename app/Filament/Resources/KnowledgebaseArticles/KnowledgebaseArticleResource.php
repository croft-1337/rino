<?php

namespace App\Filament\Resources\KnowledgebaseArticles;

use App\Filament\Resources\KnowledgebaseArticles\Pages\CreateKnowledgebaseArticle;
use App\Filament\Resources\KnowledgebaseArticles\Pages\EditKnowledgebaseArticle;
use App\Filament\Resources\KnowledgebaseArticles\Pages\ListKnowledgebaseArticles;
use App\Filament\Resources\KnowledgebaseArticles\Schemas\KnowledgebaseArticleForm;
use App\Filament\Resources\KnowledgebaseArticles\Tables\KnowledgebaseArticlesTable;
use App\Models\KnowledgebaseArticle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KnowledgebaseArticleResource extends Resource
{
    protected static ?string $model =
        KnowledgebaseArticle::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute =
        'title';

    protected static ?string $modelLabel =
        'Article';

    protected static ?string $pluralModelLabel =
        'Articles';

    protected static bool $shouldRegisterNavigation =
        false;

    public static function form(
        Schema $schema
    ): Schema {
        return KnowledgebaseArticleForm::configure(
            $schema
        );
    }

    public static function table(
        Table $table
    ): Table {
        return KnowledgebaseArticlesTable::configure(
            $table
        );
    }

    public static function getPages(): array
    {
        return [
            'index' =>
                ListKnowledgebaseArticles::route('/'),

            'create' =>
                CreateKnowledgebaseArticle::route('/create'),

            'edit' =>
                EditKnowledgebaseArticle::route('/{record}/edit'),
        ];
    }
}