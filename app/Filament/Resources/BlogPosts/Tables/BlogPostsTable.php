<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Models\BlogPost;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(
        Table $table
    ): Table {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->separator(','),

                TextColumn::make('author')
                    ->label('Author')
                    ->placeholder('—'),

                TextColumn::make('published_date')
                    ->label('Date')
                    ->date('M j, Y')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('read_time')
                    ->label('Read')
                    ->suffix(' min'),

                IconColumn::make('published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
            ])
            ->defaultSort(
                'published_date',
                'desc'
            )
            ->recordActions([
                EditAction::make()
                    ->url(
                        fn (
                            BlogPost $record
                        ): string =>
                            BlogPostResource::getUrl(
                                'edit',
                                [
                                    'record' =>
                                        $record,
                                ]
                            )
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}