@extends('layouts.app')

@section('title', $siteName)

@section('content')

    @php
        $homePage =
            \App\Models\Page::query()
                ->where('slug', 'home')
                ->where('active', true)
                ->where(
                    'page_type',
                    \App\Models\Page::TYPE_STRUCTURED
                )
                ->first();

        $sections =
            $homePage &&
            is_array($homePage->sections)
                ? $homePage->sections
                : [];
    @endphp

    @if ($homePage)

        @foreach ($sections as $block)

            @php
                $type =
                    $block['type'] ?? null;

                $data =
                    $block['data'] ?? [];
            @endphp

            @switch($type)

                @case('hero')
                    @include(
                        'components.sections.hero',
                        ['section' => $data]
                    )
                    @break

                @case('selector')
                    @include(
                        'components.sections.selector',
                        ['section' => $data]
                    )
                    @break

                @case('plans')
                    @include(
                        'components.sections.plans',
                        ['section' => $data]
                    )
                    @break

                @case('features')
                    @include(
                        'components.sections.features',
                        ['section' => $data]
                    )
                    @break

                @case('feature-showcase')
                    @include(
                        'components.sections.feature-showcase',
                        ['section' => $data]
                    )
                    @break

                @case('locations')
                    @include(
                        'components.sections.locations',
                        ['section' => $data]
                    )
                    @break

                @case('testimonials')
                    @include(
                        'components.sections.testimonials',
                        ['section' => $data]
                    )
                    @break

                @case('faq')
                    @include(
                        'components.sections.faq',
                        ['section' => $data]
                    )
                    @break

                @case('cta')
                    @include(
                        'components.sections.cta',
                        ['section' => $data]
                    )
                    @break

                @case('custom-section')
                    @include(
                        'components.sections.custom-section',
                        ['section' => $data]
                    )
                    @break

            @endswitch

        @endforeach

    @else

        <section
            class="
                flex
                min-h-[calc(100vh-var(--rino-top-stack-height))]
                items-center
                px-4
                py-20
                sm:px-6
                lg:px-8
            "
        >
            <div
                class="
                    mx-auto
                    w-full
                    max-w-7xl
                "
            >
                <div
                    class="
                        mx-auto
                        max-w-3xl
                        text-center
                    "
                >
                    <h1
                        class="
                            text-4xl
                            font-bold
                            tracking-tight
                            text-rino-heading
                            sm:text-5xl
                            lg:text-6xl
                        "
                    >
                        {{ $siteName }}
                    </h1>

                    @if (!empty($siteTagline))
                        <p
                            class="
                                mx-auto
                                mt-6
                                max-w-2xl
                                text-lg
                                leading-8
                                text-rino-muted
                            "
                        >
                            {{ $siteTagline }}
                        </p>
                    @endif

                    <div
                        class="
                            mt-8
                            text-sm
                            text-rino-muted
                        "
                    >
                        Create an active Structured Page
                        with the slug

                        <span
                            class="
                                font-semibold
                                text-rino-heading
                            "
                        >
                            home
                        </span>

                        to build the homepage.
                    </div>
                </div>
            </div>
        </section>

    @endif

@endsection