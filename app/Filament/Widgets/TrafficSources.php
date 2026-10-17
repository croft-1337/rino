<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TrafficSources extends TableWidget
{
    protected static ?string $heading =
        'Traffic Sources';

    protected static ?int $sort = 5;

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
                        "
                            MIN(id) as id,
                            COALESCE(
                                referrer_host,
                                'Direct'
                            ) as source,
                            COUNT(*) as visits,
                            COUNT(
                                DISTINCT visitor_id
                            ) as visitors
                        "
                    )
                    ->where(
                        'viewed_at',
                        '>=',
                        now()
                            ->subDays(29)
                            ->startOfDay()
                    )
                    ->groupByRaw(
                        "
                            COALESCE(
                                referrer_host,
                                'Direct'
                            )
                        "
                    )
                    ->orderByDesc(
                        'visits'
                    )
                    ->limit(10)
            )
            ->defaultKeySort(
                false
            )
            ->columns([
                TextColumn::make(
                    'source'
                )
                    ->label(
                        'Source'
                    ),

                TextColumn::make(
                    'visits'
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