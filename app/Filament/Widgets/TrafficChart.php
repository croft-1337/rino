<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Widgets\ChartWidget;

class TrafficChart extends ChartWidget
{
    protected ?string $heading =
        'Page Views vs Unique Visitors';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getData(): array
    {
        $labels = [];
        $views = [];
        $visitors = [];

        for (
            $daysAgo = 29;
            $daysAgo >= 0;
            $daysAgo--
        ) {
            $date =
                now()
                    ->subDays(
                        $daysAgo
                    );

            $start =
                $date
                    ->copy()
                    ->startOfDay();

            $end =
                $date
                    ->copy()
                    ->endOfDay();

            $query =
                SiteVisit::query()
                    ->whereBetween(
                        'viewed_at',
                        [
                            $start,
                            $end,
                        ]
                    );

            $labels[] =
                $date->format(
                    'M j'
                );

            $views[] =
                (clone $query)
                    ->count();

            $visitors[] =
                (clone $query)
                    ->distinct(
                        'visitor_id'
                    )
                    ->count(
                        'visitor_id'
                    );
        }

        return [
            'datasets' => [
                [
                    'label' =>
                        'Page Views',

                    'data' =>
                        $views,
                ],

                [
                    'label' =>
                        'Unique Visitors',

                    'data' =>
                        $visitors,
                ],
            ],

            'labels' =>
                $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}