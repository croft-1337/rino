<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Widgets\ChartWidget;

class VisitorsChart extends ChartWidget
{
    protected ?string $heading =
        'Visitors — Last 30 Days';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getData(): array
    {
        $labels = [];
        $data = [];

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

            $labels[] =
                $date->format(
                    'M j'
                );

            $data[] =
                SiteVisit::query()
                    ->whereBetween(
                        'viewed_at',
                        [
                            $start,
                            $end,
                        ]
                    )
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
                        'Unique Visitors',

                    'data' =>
                        $data,
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