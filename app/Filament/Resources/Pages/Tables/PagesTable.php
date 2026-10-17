<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Models\Page;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label('Title / Label')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('page_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string =>
                            match ($state) {
                                Page::TYPE_STRUCTURED =>
                                    'Structured',

                                Page::TYPE_DOCUMENT =>
                                    'Document',

                                Page::TYPE_EXTERNAL =>
                                    'External Link',

                                default =>
                                    ucfirst(
                                        $state ?? ''
                                    ),
                            }
                    ),

                TextColumn::make(
                    'category.name'
                )
                    ->label('Category')
                    ->placeholder('Standalone'),

                TextColumn::make('url')
                    ->label('Destination')
                    ->formatStateUsing(
                        fn (
                            ?string $state,
                            Page $record
                        ): string =>
                            $record->url
                    )
                    ->copyable()
                    ->copyMessage(
                        'Destination copied'
                    )
                    ->limit(45),

                IconColumn::make('active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                IconColumn::make(
                    'show_in_header'
                )
                    ->label('Header')
                    ->boolean()
                    ->sortable(),

                IconColumn::make(
                    'show_in_footer'
                )
                    ->label('Footer')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(
                        'M j, Y g:i A'
                    )
                    ->sortable()
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