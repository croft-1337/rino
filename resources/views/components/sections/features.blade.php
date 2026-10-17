@php

    $enabled =

        $section['enabled']

        ?? true;



    if (!$enabled) {

        return;

    }



    $heading =

        $section['heading']

        ?? null;



    $description =

        $section['description']

        ?? null;



    $alignment =

        $section['alignment']

        ?? 'left';



    $layout =

        $section['layout']

        ?? 'grid';



    if (

        $layout === 'bento'

        ||

        $layout === 'split-list'

    ) {

        $layout = 'split-grid';

    }



    $items =

        collect(

            $section['items']

            ?? []

        )

            ->filter(

                fn ($item) =>

                    (bool) (

                        $item['enabled']

                        ?? true

                    )

                    &&

                    filled(

                        $item['title']

                        ?? null

                    )

            )

            ->values();



    if ($items->isEmpty()) {

        return;

    }



    $centered =

        $alignment === 'center';

@endphp



<section

    class="

        bg-rino-background

        px-4

        py-12

        sm:px-6

        sm:py-14

        lg:px-8

        lg:py-16

    "

>

    <div

        class="

            mx-auto

            w-full

            max-w-7xl

        "

    >

        @if (

            filled($heading)

            ||

            filled($description)

        )

            <div

                class="

                    mb-8

                    max-w-3xl

                    sm:mb-10

                    {{ $centered

                        ? 'mx-auto text-center'

                        : ''

                    }}

                "

            >

                @if (filled($heading))

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



                @if (filled($description))

                    <p

                        class="

                            mt-4

                            max-w-2xl

                            text-[0.9375rem]

                            leading-[1.7]

                            text-rino-muted

                            sm:text-[1rem]

                            {{ $centered

                                ? 'mx-auto'

                                : ''

                            }}

                        "

                    >

                        {{ $description }}

                    </p>

                @endif

            </div>

        @endif



        @if ($layout === 'split-grid')

            <div

                class="

                    grid

                    grid-cols-1

                    gap-4

                    sm:grid-cols-2

                    lg:grid-cols-3

                "

            >

                @foreach ($items as $item)

                    @php

                        $visualType =

                            $item['visual_type']

                            ?? 'upload';



                        $image =

                            $item['image']

                            ?? null;



                        $html =

                            $item['html']

                            ?? null;

                    @endphp



                    <article

                        class="

                            relative

                            flex

                            h-[19rem]

                            min-w-0

                            flex-col

                            overflow-hidden

                            rounded-[var(--radius-card)]

                            bg-rino-surface

                            sm:h-[20rem]

                            lg:h-[21rem]

                        "

                    >

                        <div

                            class="

                                shrink-0

                                px-5

                                pt-5

                                sm:px-6

                                sm:pt-6

                            "

                        >

                            <h3

                                class="

                                    text-[1rem]

                                    font-semibold

                                    leading-snug

                                    tracking-tight

                                    text-rino-heading

                                    sm:text-[1.05rem]

                                "

                            >

                                {{ $item['title'] }}

                            </h3>



                            @if (

                                filled(

                                    $item['description']

                                    ?? null

                                )

                            )

                                <p

                                    class="

                                        mt-2

                                        text-[0.82rem]

                                        leading-5

                                        text-rino-muted

                                        sm:text-[0.875rem]

                                        sm:leading-6

                                    "

                                >

                                    {{ $item['description'] }}

                                </p>

                            @endif

                        </div>



                        @if (

                            $visualType === 'html'

                            &&

                            filled($html)

                        )

                            <div

                                class="

                                    relative

                                    mt-2

                                    min-h-0

                                    flex-1

                                    overflow-hidden

                                    p-3

                                "

                            >

                                <div

                                    class="

                                        h-full

                                        w-full

                                        overflow-hidden

                                    "

                                >

                                    {!! $html !!}

                                </div>

                            </div>

                        @elseif (filled($image))

                            <div

                                class="

                                    relative

                                    mt-3

                                    min-h-0

                                    flex-1

                                    overflow-hidden

                                    px-5

                                    sm:px-6

                                "

                            >

                                <div

                                    class="

                                        h-full

                                        w-full

                                        overflow-hidden

                                        rounded-t-[var(--radius-card)]

                                    "

                                >

                                    <img

                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}"

                                        alt=""

                                        class="

                                            h-full

                                            w-full

                                            object-cover

                                            object-top

                                        "

                                    >

                                </div>

                            </div>

                        @else

                            <div class="flex-1"></div>

                        @endif



                        <div

                            class="

                                pointer-events-none

                                absolute

                                inset-px

                                rounded-[var(--radius-card)]

                                ring-1

                                ring-black/5

                            "

                        ></div>

                    </article>

                @endforeach

            </div>

        @else

            <div

                class="

                    grid

                    grid-cols-1

                    gap-4

                    sm:grid-cols-2

                    lg:grid-cols-3

                "

            >

                @foreach ($items as $item)

                    <article

                        class="

                            relative

                            flex

                            min-w-0

                            flex-col

                            rounded-[var(--radius-card)]

                            bg-rino-surface

                            p-5

                            sm:p-6

                        "

                    >

                        <span

                            class="

                                flex

                                size-11

                                shrink-0

                                items-center

                                justify-center

                                rounded-[var(--radius-button)]

                                bg-rino-primary

                                text-rino-primary-text

                                sm:size-12

                            "

                        >

                            <x-sections.partials.feature-icon

                                :name="$item['icon'] ?? 'server'"

                                class="

                                    size-[1.35rem]

                                    sm:size-6

                                "

                            />

                        </span>



                        <h3

                            class="

                                mt-5

                                text-[1.05rem]

                                font-bold

                                leading-snug

                                text-rino-heading

                                sm:text-[1.1rem]

                            "

                        >

                            {{ $item['title'] }}

                        </h3>



                        @if (

                            filled(

                                $item['description']

                                ?? null

                            )

                        )

                            <p

                                class="

                                    mt-2

                                    text-[0.9rem]

                                    leading-6

                                    text-rino-muted

                                    sm:text-[0.95rem]

                                "

                            >

                                {{ $item['description'] }}

                            </p>

                        @endif

                                            <div
                            class="
                                pointer-events-none
                                absolute
                                inset-px
                                rounded-[var(--radius-card)]
                                ring-1
                                ring-black/5
                            "
                        ></div>

</article>

                @endforeach

            </div>

        @endif

    </div>

</section>