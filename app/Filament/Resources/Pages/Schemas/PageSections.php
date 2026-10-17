<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Resources\Pages\Schemas\Sections\CtaSection;
use App\Filament\Resources\Pages\Schemas\Sections\CustomSection;
use App\Filament\Resources\Pages\Schemas\Sections\FaqSection;
use App\Filament\Resources\Pages\Schemas\Sections\FeatureShowcaseSection;
use App\Filament\Resources\Pages\Schemas\Sections\FeaturesSection;
use App\Filament\Resources\Pages\Schemas\Sections\HeroSection;
use App\Filament\Resources\Pages\Schemas\Sections\LocationsSection;
use App\Filament\Resources\Pages\Schemas\Sections\PlansSection;
use App\Filament\Resources\Pages\Schemas\Sections\SelectorSection;
use App\Filament\Resources\Pages\Schemas\Sections\TestimonialsSection;

class PageSections
{
    public static function blocks(): array
    {
        return [
            HeroSection::make(),
            SelectorSection::make(),
            PlansSection::make(),
            FeaturesSection::make(),
            FeatureShowcaseSection::make(),
            LocationsSection::make(),
            TestimonialsSection::make(),
            FaqSection::make(),
            CtaSection::make(),
            CustomSection::make(),
        ];
    }
}