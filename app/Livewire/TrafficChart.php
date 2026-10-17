<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class TrafficChart extends ChartWidget
{
    protected ?string $heading = 'Traffic Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
