<?php

namespace App\Filament\Resources\Pages\Schemas\Sections;

use App\Support\LocationPresets;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class LocationsSection
{
    public static function make(): Block
    {
        return Block::make('locations')
            ->label('Locations')
            ->icon('heroicon-o-globe-alt')
            ->schema([
                Section::make('General')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(true),

                        Select::make('alignment')
                            ->label('Alignment')
                            ->options([
                                'left' => 'Left',
                                'center' => 'Center',
                            ])
                            ->default('center')
                            ->required()
                            ->native(false),

                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder('Global Server Locations')
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Deploy closer to your players with locations across our global network.'
                            )
                            ->rows(3)
                            ->maxLength(700)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Display')
                    ->schema([
                        Select::make('layout')
                            ->label('Layout')
                            ->options([
                                'map' => 'Map',
                                'map-list' => 'Map + List',
                            ])
                            ->default('map-list')
                            ->required()
                            ->native(false),
                    ]),

                Section::make('Locations')
                    ->description(
                        'Select server locations. Flags and map positions are handled automatically.'
                    )
                    ->schema([
                        Repeater::make('locations')
                            ->label('Locations')
                            ->schema([
                                Hidden::make('id')
                                    ->default(
                                        fn (): string =>
                                            (string) Str::uuid()
                                    ),

                                Toggle::make('enabled')
                                    ->label('Enabled')
                                    ->default(true),

                                Select::make('location')
                                    ->label('Location')
                                    ->options(
                                        LocationPresets::groupedOptions()
                                    )
                                    ->searchable()
                                    ->native(false)
                                    ->required()
                                    ->live()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->helperText(
                                        'Country, flag and map position are automatic.'
                                    ),

                                TextInput::make('label')
                                    ->label('Custom Label')
                                    ->placeholder(
                                        'Optional custom display name'
                                    )
                                    ->helperText(
                                        'Leave empty to use the default city and country.'
                                    )
                                    ->live(onBlur: true)
                                    ->maxLength(120),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'available' => 'Available',
                                        'limited' => 'Limited',
                                        'coming-soon' => 'Coming Soon',
                                    ])
                                    ->default('available')
                                    ->required()
                                    ->native(false),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->maxItems(
                                LocationPresets::count()
                            )
                            ->reorderable()
                            ->collapsible()
                            ->cloneable(false)
                            ->itemLabel(
                                function (array $state): string {
                                    $customLabel =
                                        trim(
                                            (string) (
                                                $state['label']
                                                ?? ''
                                            )
                                        );

                                    if ($customLabel !== '') {
                                        return $customLabel;
                                    }

                                    return LocationPresets::label(
                                        $state['location']
                                        ?? ''
                                    )
                                        ?? 'Location';
                                }
                            )
                            ->addActionLabel('Add Location')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
