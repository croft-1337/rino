<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan =
        'full';

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Visitors Today',
                $this->uniqueSince(
                    now()->startOfDay()
                )
            ),

            Stat::make(
                'Last 7 Days',
                $this->uniqueSince(
                    now()
                        ->subDays(6)
                        ->startOfDay()
                )
            ),

            Stat::make(
                'Last 30 Days',
                $this->uniqueSince(
                    now()
                        ->subDays(29)
                        ->startOfDay()
                )
            ),

            Stat::make(
                'All Time',
                SiteVisit::query()
                    ->distinct(
                        'visitor_id'
                    )
                    ->count(
                        'visitor_id'
                    )
            ),
        ];
    }

    private function uniqueSince(
        $date
    ): int {
        return SiteVisit::query()
            ->where(
                'viewed_at',
                '>=',
                $date
            )
            ->distinct(
                'visitor_id'
            )
            ->count(
                'visitor_id'
            );
    }
}