<?php

namespace App\Livewire;

use App\Filament\Resources\KnowledgebaseCategories\KnowledgebaseCategoryResource;
use App\Filament\Resources\KnowledgebaseCategories\Tables\KnowledgebaseCategoriesTable as TableConfiguration;
use App\Models\KnowledgebaseCategory;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class KnowledgebaseCategoriesTable extends Component implements
    HasTable,
    HasSchemas,
    HasActions
{
    use InteractsWithTable;
    use InteractsWithSchemas;
    use InteractsWithActions;

    public function table(
        Table $table
    ): Table {
        return TableConfiguration::configure(
            $table
        )
            ->query(
                KnowledgebaseCategory::query()
            )
            ->recordActions([
                EditAction::make()
                    ->url(
                        fn (
                            KnowledgebaseCategory $record
                        ): string =>
                            KnowledgebaseCategoryResource::getUrl(
                                'edit',
                                [
                                    'record' =>
                                        $record,
                                ]
                            )
                    ),
            ]);
    }

    public function render(): View
    {
        return view(
            'livewire.knowledgebase-categories-table'
        );
    }
}