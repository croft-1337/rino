@props([
    'name' => 'server',
])

@php
    $component =
        match ($name) {
            'server' =>
                'heroicon-s-server-stack',

            'cpu' =>
                'heroicon-s-cpu-chip',

            'memory' =>
                'heroicon-s-circle-stack',

            'storage' =>
                'heroicon-s-circle-stack',

            'database' =>
                'heroicon-s-circle-stack',

            'network' =>
                'heroicon-s-signal',

            'speed' =>
                'heroicon-s-bolt',

            'shield' =>
                'heroicon-s-shield-check',

            'lock' =>
                'heroicon-s-lock-closed',

            'support' =>
                'heroicon-s-lifebuoy',

            'clock' =>
                'heroicon-s-clock',

            'globe' =>
                'heroicon-s-globe-alt',

            'location' =>
                'heroicon-s-map-pin',

            'cloud' =>
                'heroicon-s-cloud',

            'backup' =>
                'heroicon-s-arrow-path',

            'bandwidth' =>
                'heroicon-s-chart-bar',

            'rocket' =>
                'heroicon-s-rocket-launch',

            'bolt' =>
                'heroicon-s-bolt',

            'users' =>
                'heroicon-s-user-group',

            'players' =>
                'heroicon-s-user-group',

            'gamepad' =>
                'heroicon-s-cube',

            'terminal' =>
                'heroicon-s-command-line',

            'code' =>
                'heroicon-s-code-bracket',

            'desktop' =>
                'heroicon-s-computer-desktop',

            'monitor' =>
                'heroicon-s-presentation-chart-line',

            'scale' =>
                'heroicon-s-arrows-pointing-out',

            'check' =>
                'heroicon-s-check',

            'star' =>
                'heroicon-s-star',

            'cube' =>
                'heroicon-s-cube',

            default =>
                'heroicon-s-check',
        };
@endphp

<x-dynamic-component
    :component="$component"
    {{ $attributes }}
    aria-hidden="true"
/>