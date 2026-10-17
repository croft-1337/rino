@php
    $enabled = $section['enabled'] ?? true;

    if (!$enabled) {
        return;
    }

    $heading = $section['heading'] ?? null;
    $alignment = $section['alignment'] ?? 'left';

    $groups = is_array($section['groups'] ?? null) ? $section['groups'] : [];

    $selectorId = 'rino-selector-' . \Illuminate\Support\Str::random(8);

    $normalGroups = collect($groups)
        ->filter(fn ($group) => ($group['type'] ?? 'normal') !== 'billing')
        ->values();

    $billingGroups = collect($groups)
        ->filter(fn ($group) => ($group['type'] ?? 'normal') === 'billing')
        ->values();

    $isCentered = $alignment === 'center';
@endphp

<section
    id="{{ $selectorId }}"
    data-rino-selector
    data-alignment="{{ $alignment }}"
    class="bg-rino-background px-4 pb-6 pt-7 sm:px-6 sm:pb-7 sm:pt-8 lg:px-8"
>
    <div class="mx-auto w-full max-w-7xl">
        <div
            class="
                grid gap-5
                {{ $isCentered
                    ? 'md:grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)]'
                    : 'md:grid-cols-[minmax(0,1fr)_auto]'
                }}
                md:items-start
            "
        >
            @if (filled($heading))
                <div
                    class="
                        min-w-0 md:pt-2
                        {{ $isCentered
                            ? 'md:col-start-2 md:row-start-1 md:text-center'
                            : 'text-left md:col-start-1 md:row-start-1'
                        }}
                    "
                >
                    <h2
                        class="
                            text-[2rem] font-bold tracking-tight text-rino-heading
                            sm:text-[2.25rem]
                            lg:text-[2.5rem]
                        "
                    >
                        {{ $heading }}
                    </h2>
                </div>
            @endif

            @if ($billingGroups->isNotEmpty())
                <div
                    class="
                        flex shrink-0 justify-start
                        {{ $isCentered
                            ? 'md:col-start-3 md:row-start-1 md:justify-self-end'
                            : 'md:col-start-2 md:row-start-1 md:justify-self-end'
                        }}
                    "
                >
                    @foreach ($billingGroups as $group)
                        @php
                            $groupId = $group['id'] ?? 'billing-' . $loop->index;
                        @endphp

                        <div
                            data-selector-group
                            data-group-id="{{ $groupId }}"
                            data-group-type="billing"
                            data-display-style="pills"
                            data-selected-option=""
                            class="
                                inline-flex min-h-12 max-w-full items-center overflow-x-auto
                                rounded-full border-2 border-rino-border/50 bg-rino-surface p-1
                            "
                        >
                            <div
                                data-billing-options
                                class="flex items-center gap-1"
                            ></div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($normalGroups->isNotEmpty())
            <div class="mt-7 flex flex-col gap-5">
                @foreach ($normalGroups as $group)
                    @php
                        $groupId = $group['id'] ?? 'group-' . $loop->index;

                        $options = collect($group['options'] ?? [])
                            ->filter(fn ($option) => (bool) ($option['enabled'] ?? true))
                            ->values();

                        $defaultOption = $options->first(
                            fn ($option) => (bool) ($option['default'] ?? false)
                        );

                        $selectedOptionId =
                            $defaultOption['id']
                            ?? ($options->first()['id'] ?? null);

                        $groupName = $group['name'] ?? 'Filter';
                    @endphp

                    @if ($options->isNotEmpty())
                        <div
                            data-selector-group
                            data-group-id="{{ $groupId }}"
                            data-group-type="normal"
                            data-display-style="cards"
                            data-selected-option="{{ $selectedOptionId }}"
                            class="min-w-0"
                        >
                            <div class="mb-2.5">
                                <h3
                                    class="
                                        text-[1rem] font-bold leading-none text-rino-heading
                                    "
                                >
                                    {{ $groupName }}
                                </h3>
                            </div>

                            <div
                                role="group"
                                aria-label="{{ $groupName }}"
                                class="flex min-w-0 flex-wrap items-stretch gap-2.5"
                            >
                                @foreach ($options as $option)
                                    @php
                                        $optionId = $option['id'] ?? 'option-' . $loop->index;

                                        $selected =
                                            (string) $optionId === (string) $selectedOptionId;

                                        $visualType = $option['visual_type'] ?? 'none';
                                        $hasVisual = $visualType !== 'none';
                                        $description = $option['short_description'] ?? null;
                                    @endphp

                                    <button
                                        type="button"
                                        data-selector-option
                                        data-option-id="{{ $optionId }}"
                                        data-selected="{{ $selected ? 'true' : 'false' }}"
                                        aria-pressed="{{ $selected ? 'true' : 'false' }}"
                                        class="
                                            relative flex min-h-[4.25rem] w-full min-w-0 items-center gap-3
                                            overflow-hidden rounded-[var(--radius-card)] border-2
                                            border-rino-border/50 bg-rino-surface px-4 py-2.5 text-left
                                            text-rino-body transition duration-200
                                            hover:border-rino-border hover:bg-rino-surface-secondary
                                            data-[selected=true]:border-rino-primary/70
                                            data-[selected=true]:bg-rino-primary/10
                                            sm:w-[12.5rem] md:w-[13.25rem] lg:w-[13.75rem] xl:w-[14rem]
                                        "
                                    >
                                        <span class="min-w-0 flex-1">
                                            <span
                                                class="
                                                    block truncate text-[0.9375rem] font-semibold
                                                    leading-snug text-rino-heading
                                                "
                                            >
                                                {{ $option['name'] ?? 'Option' }}
                                            </span>

                                            @if (filled($description))
                                                <span
                                                    class="
                                                        mt-1 block line-clamp-2 text-[0.8125rem]
                                                        leading-relaxed text-rino-muted
                                                    "
                                                >
                                                    {{ $description }}
                                                </span>
                                            @endif
                                        </span>

                                        @if ($hasVisual)
                                            <span
                                                class="
                                                    ml-auto flex h-8 w-10 shrink-0 items-center
                                                    justify-center overflow-hidden rounded-md
                                                "
                                            >
                                                @include(
                                                    'components.sections.partials.selector-visual',
                                                    [
                                                        'type' => $visualType,
                                                        'asset' => $option['built_in_asset'] ?? null,
                                                        'icon' => $option['icon'] ?? null,
                                                        'image' => $option['image'] ?? null,
                                                    ]
                                                )
                                            </span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <script>
        (() => {
            const root = document.getElementById(@js($selectorId));

            if (!root) {
                return;
            }

            const emitChange = (group, optionId) => {
                group.dataset.selectedOption = String(optionId);

                root.dispatchEvent(
                    new CustomEvent('rino:selector-change', {
                        bubbles: true,
                        detail: {
                            selectorId: root.id,
                            groupId: group.dataset.groupId,
                            groupType: group.dataset.groupType,
                            optionId: String(optionId),
                        },
                    })
                );
            };

            const setSelectedButton = (group, selectedButton) => {
                group.querySelectorAll('[data-selector-option]').forEach((button) => {
                    const selected = button === selectedButton;

                    button.dataset.selected = selected ? 'true' : 'false';
                    button.setAttribute('aria-pressed', selected ? 'true' : 'false');
                });
            };

            root.querySelectorAll('[data-selector-group][data-group-type="normal"]').forEach(
                (group) => {
                    const buttons = Array.from(
                        group.querySelectorAll('[data-selector-option]')
                    );

                    buttons.forEach((button) => {
                        button.addEventListener('click', () => {
                            const optionId = button.dataset.optionId;

                            if (!optionId) {
                                return;
                            }

                            setSelectedButton(group, button);
                            emitChange(group, optionId);
                        });
                    });
                }
            );
        })();
    </script>
</section>
