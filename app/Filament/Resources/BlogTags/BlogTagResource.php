<?php

namespace App\Filament\Resources\BlogTags;

use App\Filament\Resources\BlogTags\Pages\CreateBlogTag;
use App\Filament\Resources\BlogTags\Pages\EditBlogTag;
use App\Filament\Resources\BlogTags\Pages\ListBlogTags;
use App\Filament\Resources\BlogTags\Schemas\BlogTagForm;
use App\Filament\Resources\BlogTags\Tables\BlogTagsTable;
use App\Models\BlogTag;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BlogTagResource extends Resource
{
    protected static ?string $model =
        BlogTag::class;

    protected static ?string $recordTitleAttribute =
        'name';

    protected static ?string $modelLabel =
        'Blog Tag';

    protected static ?string $pluralModelLabel =
        'Blog Tags';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(
        Schema $schema
    ): Schema {
        return BlogTagForm::configure(
            $schema
        );
    }

    public static function table(
        Table $table
    ): Table {
        return BlogTagsTable::configure(
            $table
        );
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' =>
                ListBlogTags::route('/'),

            'create' =>
                CreateBlogTag::route(
                    '/create'
                ),

            'edit' =>
                EditBlogTag::route(
                    '/{record}/edit'
                ),
        ];
    }
}