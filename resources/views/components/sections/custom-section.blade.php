@php
    $enabled =
        $section['enabled']
        ?? true;

    if (!$enabled) {
        return;
    }

    $heading =
        trim(
            (string) (
                $section['heading']
                ?? ''
            )
        );

    $description =
        trim(
            (string) (
                $section['description']
                ?? ''
            )
        );

    $html =
        (string) (
            $section['html']
            ?? ''
        );

    $css =
        (string) (
            $section['css']
            ?? ''
        );

    $javascript =
        (string) (
            $section['javascript']
            ?? ''
        );

    $sectionId =
        'rino-custom-' .
        \Illuminate\Support\Str::random(10);
@endphp

<section
    id="{{ $sectionId }}"
    class="
        bg-rino-background
        px-4
        py-16
        sm:px-6
        sm:py-20
        lg:px-8
        lg:py-24
    "
    data-rino-custom-section
>
    <div
        class="
            mx-auto
            w-full
            max-w-7xl
        "
    >
        @if ($heading !== '' || $description !== '')
            <div
                class="
                    mb-10
                    max-w-3xl
                    sm:mb-12
                "
            >
                @if ($heading !== '')
                    <h2
                        class="
                            text-[2rem]
                            font-bold
                            leading-tight
                            tracking-tight
                            text-rino-heading
                            sm:text-[2.25rem]
                            lg:text-[2.5rem]
                        "
                    >
                        {{ $heading }}
                    </h2>
                @endif

                @if ($description !== '')
                    <p
                        class="
                            mt-4
                            max-w-2xl
                            text-[0.9375rem]
                            leading-[1.7]
                            text-rino-muted
                            sm:text-[1rem]
                        "
                    >
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        @if (trim($html) !== '')
            <div data-rino-custom-content>
                {!! $html !!}
            </div>
        @endif
    </div>

    @if (trim($css) !== '')
        <style>
            {!! $css !!}
        </style>
    @endif

    @if (trim($javascript) !== '')
        <script>
            (() => {
                const section =
                    document.getElementById(
                        @js($sectionId)
                    );

                if (!section) {
                    return;
                }

                {!! $javascript !!}
            })();
        </script>
    @endif
</section>