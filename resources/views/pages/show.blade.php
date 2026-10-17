@extends('layouts.app')

@section(
    'title',
    $page->title . ' | ' . $siteName
)

@section('content')

    @if (
        $page->page_type ===
        \App\Models\Page::TYPE_STRUCTURED
    )

        @php
            $sections =
                is_array($page->sections)
                    ? $page->sections
                    : [];
        @endphp

        @foreach ($sections as $block)

            @php
                $type =
                    $block['type']
                    ?? null;

                $data =
                    $block['data']
                    ?? [];
            @endphp

            @switch($type)

                @case('hero')
                    @include(
                        'components.sections.hero',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('selector')
                    @include(
                        'components.sections.selector',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('plans')
                    @include(
                        'components.sections.plans',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('features')
                    @include(
                        'components.sections.features',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('feature-showcase')
                    @include(
                        'components.sections.feature-showcase',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('locations')
                    @include(
                        'components.sections.locations',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('testimonials')
                    @include(
                        'components.sections.testimonials',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('faq')
                    @include(
                        'components.sections.faq',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('cta')
                    @include(
                        'components.sections.cta',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

                @case('custom-section')
                    @include(
                        'components.sections.custom-section',
                        [
                            'section' =>
                                $data,
                        ]
                    )
                    @break

            @endswitch

        @endforeach

    @elseif (
        $page->page_type ===
        \App\Models\Page::TYPE_DOCUMENT
    )

        @include(
            'pages.document',
            [
                'page' =>
                    $page,
            ]
        )

    @endif

@endsection