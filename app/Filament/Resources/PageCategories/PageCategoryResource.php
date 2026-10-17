<?php

namespace App\Filament\Resources\PageCategories;

use App\Filament\Resources\PageCategories\Pages\CreatePageCategory;
use App\Filament\Resources\PageCategories\Pages\EditPageCategory;
use App\Filament\Resources\PageCategories\Pages\ListPageCategories;
use App\Filament\Resources\PageCategories\Schemas\PageCategoryForm;
use App\Filament\Resources\PageCategories\Tables\PageCategoriesTable;
use App\Models\PageCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PageCategoryResource extends Resource
{
    protected static ?string $model =
        PageCategory::class;

    protected static string|UnitEnum|null $navigationGroup =
        'Website';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleGroup;

    protected static ?string $navigationLabel =
        'Categories';

    protected static ?string $modelLabel =
        'Category';

    protected static ?string $pluralModelLabel =
        'Categories';

    protected static ?string $recordTitleAttribute =
        'name';

    protected static ?int $navigationSort =
        3;

    public static function form(
        Schema $schema
    ): Schema {
        return PageCategoryForm::configure(
            $schema
        );
    }

    public static function table(
        Table $table
    ): Table {
        return PageCategoriesTable::configure(
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
                ListPageCategories::route('/'),

            'create' =>
                CreatePageCategory::route(
                    '/create'
                ),

            'edit' =>
                EditPageCategory::route(
                    '/{record}/edit'
                ),
        ];
    }
}