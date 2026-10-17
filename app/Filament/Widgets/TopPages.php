<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TopPages extends TableWidget
{
    protected static ?string $heading =
        'Top Pages';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    public function table(
        Table $table
    ): Table {
        return $table
            ->query(
                SiteVisit::query()
                    ->selectRaw(
                        '
                            MIN(id) as id,
                            path,
                            COUNT(*) as views,
                            COUNT(DISTINCT visitor_id)
                                as visitors
                        '
                    )
                    ->where(
                        'viewed_at',
                        '>=',
                        now()
                            ->subDays(29)
                            ->startOfDay()
                    )
                    ->groupBy(
                        'path'
                    )
                    ->orderByDesc(
                        'views'
                    )
                    ->limit(10)
            )
            ->defaultKeySort(
                false
            )
            ->columns([
                TextColumn::make(
                    'path'
                )
                    ->label(
                        'Page'
                    ),

                TextColumn::make(
                    'views'
                )
                    ->label(
                        'Views'
                    )
                    ->numeric(),

                TextColumn::make(
                    'visitors'
                )
                    ->label(
                        'Visitors'
                    )
                    ->numeric(),
            ])
            ->paginated(
                false
            );
    }
}