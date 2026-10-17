<?php

namespace App\Filament\Resources\PageCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageCategoriesTable
{
    public static function configure(
        Table $table
    ): Table {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Category')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('pages_count')
                    ->label('Entries')
                    ->counts('pages'),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(
                        'M j, Y g:i A'
                    )
                    ->toggleable(),

            ])
            ->defaultSort(
                'sort_order'
            )
            ->reorderable(
                'sort_order'
            )
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}