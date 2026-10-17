<?php

use App\Models\Page;

return [
    'title' =>
        'Home',

    'slug' =>
        'home',

    'category' =>
        null,

    'template' =>
        'standard',

    'page_type' =>
        Page::TYPE_STRUCTURED,

    'short_description' =>
        'Fast, reliable hosting for websites, game servers, and applications with flexible resources and simple management.',

    'active' =>
        true,

    'show_in_header' =>
        false,

    'show_in_footer' =>
        false,

    'system_page' =>
        true,

    'sort_order' =>
        0,

    'published' =>
        true,

    'sections' => [
        [
            'type' =>
                'hero',

            'data' => [
                'enabled' =>
                    true,

                'alignment' =>
                    'center',

                'top_element' =>
                    'social_proof',

                'tag_text' =>
                    'Premium Hosting',

                'social_proof_avatars' => [
                    [
                        'image' =>
                            'assets/avatars/avatar-1.png',
                    ],
                    [
                        'image' =>
                            'assets/avatars/avatar-2.png',
                    ],
                    [
                        'image' =>
                            'assets/avatars/avatar-3.png',
                    ],
                ],

                'social_proof_title' => 'Trustpilot',

                'social_proof_subtitle' => 'Trusted by 40+ clients',

                'heading' =>
                    'High Performance Hosting for Everything You Build',

                'highlighted_text' =>
                    'Hosting',

                'description' =>
                    'Fast, reliable hosting for websites, game servers, and applications with NVMe storage, global networking, and straightforward management.',

                'primary_button_enabled' =>
                    true,

                'primary_button_label' =>
                    'Explore Hosting',

                'primary_button_url' =>
                    '/minecraft-hosting',

                'primary_button_style' =>
                    'icon-circle',

                'primary_button_icon' =>
                    'arrow-right',

                'secondary_button_enabled' =>
                    true,

                'secondary_button_label' =>
                    'Learn More',

                'secondary_button_url' =>
                    '#features',

                'secondary_button_style' =>
                    'normal',

                'secondary_button_icon' =>
                    'none',

                'background_image' =>
                    null,

                'background_position' =>
                    'center',
            ],
        ],


        [
            'type' =>
                'custom-section',

            'data' => [
                'enabled' =>
                    true,

                'heading' =>
                    null,

                'description' =>
                    null,

                'html' => <<<'RINO_HTML'
<div
    class="rino-home-games"
    data-rino-home-games
>
    <div class="rino-home-games-grid">
        <a
            href="/minecraft-hosting"
            class="rino-home-game-card"
        >
            <img
                src="/assets/hero-bg/minecraft-bg.webp"
                alt="Minecraft"
                class="rino-home-game-image"
            >
            <span class="rino-home-game-shade"></span>
            <span class="rino-home-game-content">
                <strong class="rino-home-game-name">
                    Minecraft
                </strong>
                <span class="rino-home-game-action">
                    View Hosting
                    <svg
                        viewBox="0 0 20 20"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 10h12"></path>
                        <path d="m11 5 5 5-5 5"></path>
                    </svg>
                </span>
            </span>
        </a>

        <a
            href="/hytale-hosting"
            class="rino-home-game-card"
        >
            <img
                src="/assets/hero-bg/hytale-bg.jpg"
                alt="Hytale"
                class="rino-home-game-image"
            >
            <span class="rino-home-game-shade"></span>
            <span class="rino-home-game-content">
                <strong class="rino-home-game-name">
                    Hytale
                </strong>
                <span class="rino-home-game-action">
                    View Hosting
                    <svg
                        viewBox="0 0 20 20"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 10h12"></path>
                        <path d="m11 5 5 5-5 5"></path>
                    </svg>
                </span>
            </span>
        </a>

        <a
            href="/rust-hosting"
            class="rino-home-game-card"
        >
            <img
                src="/assets/hero-bg/rust-bg.jpg"
                alt="Rust"
                class="rino-home-game-image"
            >
            <span class="rino-home-game-shade"></span>
            <span class="rino-home-game-content">
                <strong class="rino-home-game-name">
                    Rust
                </strong>
                <span class="rino-home-game-action">
                    View Hosting
                    <svg
                        viewBox="0 0 20 20"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 10h12"></path>
                        <path d="m11 5 5 5-5 5"></path>
                    </svg>
                </span>
            </span>
        </a>

        <a
            href="/ark-hosting"
            class="rino-home-game-card"
        >
            <img
                src="/assets/hero-bg/ark-bg.jpg"
                alt="ARK"
                class="rino-home-game-image"
            >
            <span class="rino-home-game-shade"></span>
            <span class="rino-home-game-content">
                <strong class="rino-home-game-name">
                    ARK
                </strong>
                <span class="rino-home-game-action">
                    View Hosting
                    <svg
                        viewBox="0 0 20 20"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 10h12"></path>
                        <path d="m11 5 5 5-5 5"></path>
                    </svg>
                </span>
            </span>
        </a>

        <a
            href="/cs2-hosting"
            class="rino-home-game-card"
        >
            <img
                src="/assets/hero-bg/cs2-bg.jpeg"
                alt="Counter-Strike 2"
                class="rino-home-game-image"
            >
            <span class="rino-home-game-shade"></span>
            <span class="rino-home-game-content">
                <strong class="rino-home-game-name">
                    Counter-Strike 2
                </strong>
                <span class="rino-home-game-action">
                    View Hosting
                    <svg
                        viewBox="0 0 20 20"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 10h12"></path>
                        <path d="m11 5 5 5-5 5"></path>
                    </svg>
                </span>
            </span>
        </a>

        <a
            href="/fivem-hosting"
            class="rino-home-game-card"
        >
            <img
                src="/assets/hero-bg/fivem-bg.jpg"
                alt="FiveM"
                class="rino-home-game-image"
            >
            <span class="rino-home-game-shade"></span>
            <span class="rino-home-game-content">
                <strong class="rino-home-game-name">
                    FiveM
                </strong>
                <span class="rino-home-game-action">
                    View Hosting
                    <svg
                        viewBox="0 0 20 20"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 10h12"></path>
                        <path d="m11 5 5 5-5 5"></path>
                    </svg>
                </span>
            </span>
        </a>
    </div>
</div>
RINO_HTML,

                'css' => <<<'RINO_CSS'
.rino-home-games {
    width: 100%;
}

.rino-home-games-grid {
    display: grid;
    grid-template-columns:
        repeat(
            3,
            minmax(0, 1fr)
        );
    gap: 1rem;
}

.rino-home-game-card {
    position: relative;
    display: block;
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    border-radius:
        var(--radius-card);
    background:
        var(--surface);
    text-decoration: none;
    isolation: isolate;
    transform:
        translateZ(0);
}

.rino-home-game-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform:
        scale(1.01);
    transition:
        transform 700ms
            cubic-bezier(
                0.16,
                1,
                0.3,
                1
            ),
        filter 700ms
            cubic-bezier(
                0.16,
                1,
                0.3,
                1
            );
    backface-visibility: hidden;
    will-change:
        transform,
        filter;
}

.rino-home-game-shade {
    position: absolute;
    inset: 0;
    z-index: 1;
    display: block;
    background:
        rgba(0, 0, 0, 0.12);
    transition:
        background 700ms
            cubic-bezier(
                0.16,
                1,
                0.3,
                1
            );
    pointer-events: none;
}

.rino-home-game-content {
    position: absolute;
    inset:
        auto
        0
        0
        0;
    z-index: 2;
    display: block;
    padding: 1.25rem;
    opacity: 0;
    transform:
        translateY(18px);
    transition:
        opacity 500ms
            cubic-bezier(
                0.16,
                1,
                0.3,
                1
            ),
        transform 500ms
            cubic-bezier(
                0.16,
                1,
                0.3,
                1
            );
    pointer-events: none;
}

.rino-home-game-name {
    display: block;
    margin: 0;
    color: #ffffff;
    font-size: 1.45rem;
    line-height: 1.15;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.rino-home-game-action {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    margin-top: 0.5rem;
    color:
        rgba(
            255,
            255,
            255,
            0.78
        );
    font-size: 0.875rem;
    line-height: 1.4;
    font-weight: 600;
}

.rino-home-game-action svg {
    width: 0.9rem;
    height: 0.9rem;
    transition:
        transform 300ms ease;
}

.rino-home-game-card:hover
.rino-home-game-image,
.rino-home-game-card:focus-visible
.rino-home-game-image {
    transform:
        scale(1.09);
    filter:
        blur(2px);
}

.rino-home-game-card:hover
.rino-home-game-shade,
.rino-home-game-card:focus-visible
.rino-home-game-shade {
    background:
        rgba(0, 0, 0, 0.57);
}

.rino-home-game-card:hover
.rino-home-game-content,
.rino-home-game-card:focus-visible
.rino-home-game-content {
    opacity: 1;
    transform:
        translateY(0);
}

.rino-home-game-card:hover
.rino-home-game-action svg,
.rino-home-game-card:focus-visible
.rino-home-game-action svg {
    transform:
        translateX(3px);
}

@media (
    max-width: 1023px
) {
    .rino-home-games-grid {
        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );
    }
}

@media (
    max-width: 639px
) {
    .rino-home-games-grid {
        grid-template-columns:
            1fr;
        gap: 0.75rem;
    }

    .rino-home-game-content {
        padding: 1rem;
    }

    .rino-home-game-name {
        font-size: 1.25rem;
    }
}

@media (
    hover: none
) {
    .rino-home-game-shade {
        background:
            rgba(0, 0, 0, 0.44);
    }

    .rino-home-game-content {
        opacity: 1;
        transform:
            translateY(0);
    }
}

@media (
    prefers-reduced-motion: reduce
) {
    .rino-home-game-image,
    .rino-home-game-shade,
    .rino-home-game-content,
    .rino-home-game-action svg {
        transition:
            none !important;
    }
}
RINO_CSS,

                'javascript' => '',
            ],
        ],

        [
            'type' => 'features',
            'data' => [
                'enabled' => true,
                'alignment' => 'center',
                'heading' => 'Hosting for every project',
                'description' => 'The essentials for reliable game servers, websites, applications, and online projects.',
                'layout' => 'split-grid',
                'items' => [
                    [
                        'id' => 'home-feature-1',
                        'enabled' => true,
                        'title' => 'Server Locations',
                        'description' => 'Choose a location close to your players for a better connection.',
                        'visual_type' => 'html',
                        'image' => null,
                        'html' => <<<'RINO_EMBED_HTML'
<style>
    .rino-location-visual {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 220px;
        overflow: hidden;
        box-sizing: border-box;
        font-family: var(--font-body);
    }

    .rino-location-canvas {
        position: absolute;
        inset: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        display: block;
        pointer-events: none;
    }

    .rino-location-pills {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
    }

    .rino-location-pill {
        position: absolute;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 5px 8px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--surface);
        color: var(--text-heading);
        white-space: nowrap;
        box-shadow: none;
        transform: translate(-50%, -50%);
    }

    .rino-location-pill img {
        display: block;
        width: 16px;
        height: 16px;
        flex: 0 0 16px;
        border-radius: 4px;
        object-fit: cover;
        box-shadow: none;
    }

    .rino-location-pill span {
        color: var(--text-heading);
        font-size: 11px;
        line-height: 1;
        font-weight: 600;
        letter-spacing: 0;
    }
</style>

<div class="rino-location-visual" data-rino-location-visual>
    <canvas
        class="rino-location-canvas"
        data-rino-location-rings
        aria-hidden="true"
    ></canvas>

    <div class="rino-location-pills">
        <div
            class="rino-location-pill"
            data-radius="1.02"
            data-angle="1.50"
        >
            <img
                src="/assets/flags/sg.png"
                alt="Singapore"
            >
            <span>Singapore</span>
        </div>

        <div
            class="rino-location-pill"
            data-radius="0.84"
            data-angle="1.70"
        >
            <img
                src="/assets/flags/de.png"
                alt="Germany"
            >
            <span>Germany</span>
        </div>

        <div
            class="rino-location-pill"
            data-radius="0.66"
            data-angle="1.39"
        >
            <img
                src="/assets/flags/nl.png"
                alt="Netherlands"
            >
            <span>Netherlands</span>
        </div>

        <div
            class="rino-location-pill"
            data-radius="0.49"
            data-angle="1.25"
        >
            <img
                src="/assets/flags/us.png"
                alt="United States"
            >
            <span>United States</span>
        </div>

        <div
            class="rino-location-pill"
            data-radius="0.32"
            data-angle="1.72"
        >
            <img
                src="/assets/flags/jp.png"
                alt="Japan"
            >
            <span>Japan</span>
        </div>
    </div>
</div>

<script>
(() => {
    const script =
        document.currentScript;

    const wrapper =
        script?.previousElementSibling;

    if (!wrapper) {
        return;
    }

    const canvas =
        wrapper.querySelector(
            '[data-rino-location-rings]'
        );

    const pills =
        Array.from(
            wrapper.querySelectorAll(
                '.rino-location-pill'
            )
        );

    if (!canvas) {
        return;
    }

    const ctx =
        canvas.getContext('2d');

    function getCssColor(
        variable,
        fallback
    ) {
        const value =
            getComputedStyle(wrapper)
                .getPropertyValue(variable)
                .trim();

        return value || fallback;
    }

    function resolveColor(
        value,
        fallback
    ) {
        const probe =
            document.createElement('span');

        probe.style.position =
            'fixed';

        probe.style.visibility =
            'hidden';

        probe.style.pointerEvents =
            'none';

        probe.style.color =
            value || fallback;

        document.body.appendChild(
            probe
        );

        const result =
            getComputedStyle(probe)
                .color;

        probe.remove();

        return result || fallback;
    }

    function rgbaFromColor(
        value,
        alpha,
        fallback
    ) {
        const resolved =
            resolveColor(
                value,
                fallback
            );

        const channels =
            resolved.match(/[\d.]+/g);

        if (
            !channels ||
            channels.length < 3
        ) {
            return resolveColor('var(--border)', 'currentColor');
        }

        return `rgba(
            ${channels[0]},
            ${channels[1]},
            ${channels[2]},
            ${alpha}
        )`;
    }

    function draw() {
        const rect =
            wrapper.getBoundingClientRect();

        const width =
            rect.width;

        const height =
            rect.height;

        if (
            width <= 0 ||
            height <= 0
        ) {
            return;
        }

        const dpr =
            Math.min(
                window.devicePixelRatio || 1,
                2
            );

        canvas.width =
            Math.round(
                width * dpr
            );

        canvas.height =
            Math.round(
                height * dpr
            );

        ctx.setTransform(
            dpr,
            0,
            0,
            dpr,
            0,
            0
        );

        ctx.clearRect(
            0,
            0,
            width,
            height
        );

        const primary =
            getCssColor(
                '--primary',
                getCssColor('--text-heading', 'currentColor')
            );

        const centerX =
            width * 0.5;

        const centerY =
            height * 1.02;

        const baseRadius =
            height * 0.93;

        const radiusFactors = [
            1.02,
            0.84,
            0.66,
            0.49,
            0.32
        ];

        ctx.lineWidth =
            1.25;

        ctx.setLineDash(
            [4, 7]
        );

        ctx.lineCap =
            'round';

        ctx.strokeStyle =
            rgbaFromColor(
                primary,
                0.34,
                getCssColor('--text-heading', 'currentColor')
            );

        radiusFactors.forEach(
            factor => {
                const radius =
                    baseRadius * factor;

                ctx.beginPath();

                ctx.arc(
                    centerX,
                    centerY,
                    radius,
                    Math.PI * 1.08,
                    Math.PI * 1.92,
                    false
                );

                ctx.stroke();
            }
        );

        ctx.setLineDash([]);

        pills.forEach(
            pill => {
                const radiusFactor =
                    Number(
                        pill.dataset.radius
                    );

                const angleFactor =
                    Number(
                        pill.dataset.angle
                    );

                const radius =
                    baseRadius *
                    radiusFactor;

                const angle =
                    Math.PI *
                    angleFactor;

                const x =
                    centerX +
                    Math.cos(angle) *
                    radius;

                const y =
                    centerY +
                    Math.sin(angle) *
                    radius;

                pill.style.left =
                    `${x}px`;

                pill.style.top =
                    `${y}px`;
            }
        );
    }

    const observer =
        new ResizeObserver(
            draw
        );

    observer.observe(
        wrapper
    );

    draw();
})();
</script>
RINO_EMBED_HTML,
                    ],
                    [
                        'id' => 'home-feature-2',
                        'enabled' => true,
                        'title' => 'DDoS Protection',
                        'description' => 'Protection helps keep your server online during network attacks.',
                        'visual_type' => 'html',
                        'image' => null,
                        'html' => <<<'RINO_EMBED_HTML'
<style>
    @keyframes rino-ddos-badge-evaporate {
        0% {
            opacity: 0;
            transform: translateY(9px);
        }

        14% {
            opacity: 1;
            transform: translateY(0);
        }

        58% {
            opacity: 1;
            transform: translateY(-6px);
        }

        82% {
            opacity: 0.35;
            transform: translateY(-13px);
        }

        100% {
            opacity: 0;
            transform: translateY(-18px);
        }
    }

    .rino-ddos-badge {
        position: absolute;
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 6px;
        background: var(--surface-secondary);
        color: var(--text-muted);
        font-size: 8px;
        line-height: 1;
        font-weight: 600;
        pointer-events: none;
        white-space: nowrap;
        opacity: 0;
        animation: rino-ddos-badge-evaporate 5.4s ease-out infinite;
    }

    .rino-ddos-badge-1 {
        top: 12%;
        right: 10px;
        animation-delay: 0s;
    }

    .rino-ddos-badge-2 {
        top: 43%;
        left: 43%;
        animation-delay: 1.8s;
    }

    .rino-ddos-badge-3 {
        top: 67%;
        left: 14px;
        animation-delay: 3.6s;
    }

    @media (prefers-reduced-motion: reduce) {
        .rino-ddos-badge {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }

        .rino-ddos-badge-2,
        .rino-ddos-badge-3 {
            display: none;
        }
    }
</style>

<div
    style="
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        overflow: hidden;
        font-family: var(--font-body);
    "
>
    <div
        style="
            position: relative;
            width: 100%;
            height: 170px;
            overflow: hidden;
        "
    >
        <canvas
            id="rinoDdosCanvas"
            style="
                width: 100%;
                height: 100%;
                display: block;
            "
        ></canvas>

        <div class="rino-ddos-badge rino-ddos-badge-1">
            Protection Active
        </div>

        <div class="rino-ddos-badge rino-ddos-badge-2">
            Threats Blocked
        </div>

        <div class="rino-ddos-badge rino-ddos-badge-3">
            1.2 Tbps Capacity
        </div>
    </div>
</div>

<script>
    (() => {
        const canvas = document.getElementById('rinoDdosCanvas');

        if (!canvas) return;

        const ctx = canvas.getContext('2d');

        const historyLength = 220;
        const points = new Array(historyLength).fill(0);

        let stepCounter = 0;
        let nextSpikeIn = 14;
        let currentSpikeHeight = 0.65;
        let currentSpikeWidth = 18;
        let spikeProgress = 999;

        function themeVariable(name, fallback) {
            const value = getComputedStyle(canvas)
                .getPropertyValue(name)
                .trim();

            return value || fallback;
        }

        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;

            canvas.width = Math.max(
                1,
                Math.round(rect.width * dpr)
            );

            canvas.height = Math.max(
                1,
                Math.round(rect.height * dpr)
            );

            ctx.setTransform(
                dpr,
                0,
                0,
                dpr,
                0,
                0
            );
        }

        function drawGrid(width, height) {
            const border = themeVariable(
                '--border',
                '#334155'
            );

            ctx.save();

            ctx.strokeStyle = border;
            ctx.globalAlpha = 0.12;
            ctx.lineWidth = 1;

            for (
                let y = 30;
                y < height;
                y += 45
            ) {
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(width, y);
                ctx.stroke();
            }

            for (
                let x = 60;
                x < width;
                x += 90
            ) {
                ctx.beginPath();
                ctx.moveTo(x, 0);
                ctx.lineTo(x, height);
                ctx.stroke();
            }

            ctx.restore();
        }

        function edgeStrength(index) {
            const progress =
                index / (historyLength - 1);

            const distanceFromEdge =
                Math.min(
                    progress,
                    1 - progress
                );

            if (distanceFromEdge < 0.08) {
                return 0.08;
            }

            if (distanceFromEdge < 0.16) {
                return 0.28;
            }

            if (distanceFromEdge < 0.23) {
                return 0.58;
            }

            return 1;
        }

        function animate() {
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;

            if (!width || !height) {
                requestAnimationFrame(animate);
                return;
            }

            const centerY = height / 2;

            const primary = themeVariable(
                '--primary',
                '#6366f1'
            );

            ctx.clearRect(
                0,
                0,
                width,
                height
            );

            drawGrid(width, height);

            stepCounter++;

            if (stepCounter >= nextSpikeIn) {
                stepCounter = 0;
                spikeProgress = 0;

                nextSpikeIn =
                    Math.floor(
                        Math.random() * 14
                    ) + 14;

                currentSpikeWidth =
                    Math.floor(
                        Math.random() * 9
                    ) + 15;

                currentSpikeHeight =
                    (Math.random() * 0.48 + 0.28) *
                    (
                        Math.random() > 0.5
                            ? 1
                            : -1
                    );
            }

            let value =
                (Math.random() - 0.5) *
                0.035;

            if (
                spikeProgress <=
                currentSpikeWidth
            ) {
                const progress =
                    spikeProgress /
                    currentSpikeWidth;

                if (progress <= 0.5) {
                    value =
                        currentSpikeHeight *
                        (progress * 2);
                } else {
                    value =
                        currentSpikeHeight *
                        (
                            (1 - progress) *
                            2
                        );
                }

                spikeProgress++;
            }

            points.shift();
            points.push(value);

            const step =
                width /
                (historyLength - 1);

            const getPoint = (index) => {
                const strength =
                    edgeStrength(index);

                return {
                    x: index * step,

                    y:
                        centerY +
                        points[index] *
                        strength *
                        (height * 0.38),
                };
            };

            const gradient =
                ctx.createLinearGradient(
                    0,
                    centerY - height * 0.35,
                    0,
                    height
                );

            gradient.addColorStop(
                0,
                primary
            );

            gradient.addColorStop(
                0.6,
                primary
            );

            gradient.addColorStop(
                1,
                'transparent'
            );

            ctx.save();

            ctx.globalAlpha = 0.13;

            ctx.beginPath();

            for (
                let i = 0;
                i < points.length;
                i++
            ) {
                const point =
                    getPoint(i);

                if (i === 0) {
                    ctx.moveTo(
                        point.x,
                        point.y
                    );
                } else {
                    ctx.lineTo(
                        point.x,
                        point.y
                    );
                }
            }

            ctx.lineTo(
                width,
                height
            );

            ctx.lineTo(
                0,
                height
            );

            ctx.closePath();

            ctx.fillStyle = gradient;
            ctx.fill();

            ctx.restore();

            ctx.beginPath();

            for (
                let i = 0;
                i < points.length;
                i++
            ) {
                const point =
                    getPoint(i);

                if (i === 0) {
                    ctx.moveTo(
                        point.x,
                        point.y
                    );
                } else {
                    ctx.lineTo(
                        point.x,
                        point.y
                    );
                }
            }

            ctx.strokeStyle = primary;
            ctx.lineWidth = 2;
            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';

            ctx.stroke();

            requestAnimationFrame(animate);
        }

        const observer =
            new ResizeObserver(() => {
                resizeCanvas();
            });

        observer.observe(canvas);

        resizeCanvas();
        animate();
    })();
</script>
RINO_EMBED_HTML,
                    ],
                    [
                        'id' => 'home-feature-3',
                        'enabled' => true,
                        'title' => 'Support, Any Time',
                        'description' => 'Get help from our team whenever you need it.',
                        'visual_type' => 'html',
                        'image' => null,
                        'html' => <<<'RINO_EMBED_HTML'
<style>
    @keyframes rino-chat-customer-in {
        from {
            opacity: 0;
            transform: translateX(-6px) translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateX(0) translateY(0);
        }
    }

    @keyframes rino-chat-staff-in {
        from {
            opacity: 0;
            transform: translateX(6px) translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateX(0) translateY(0);
        }
    }

    @keyframes rino-chat-line-in-left {
        from {
            opacity: 0;
            transform: scaleX(0.82);
        }

        to {
            opacity: 1;
            transform: scaleX(1);
        }
    }

    @keyframes rino-chat-line-in-right {
        from {
            opacity: 0;
            transform: scaleX(0.82);
        }

        to {
            opacity: 1;
            transform: scaleX(1);
        }
    }

    .rino-chat-customer {
        opacity: 0;
        animation: rino-chat-customer-in 0.4s ease-out 0.15s forwards;
    }

    .rino-chat-staff {
        opacity: 0;
        animation: rino-chat-staff-in 0.4s ease-out 0.65s forwards;
    }

    .rino-chat-customer-line-1 {
        opacity: 0;
        transform-origin: left center;
        animation: rino-chat-line-in-left 0.3s ease-out 0.4s forwards;
    }

    .rino-chat-customer-line-2 {
        opacity: 0;
        transform-origin: left center;
        animation: rino-chat-line-in-left 0.3s ease-out 0.52s forwards;
    }

    .rino-chat-staff-line-1 {
        opacity: 0;
        transform-origin: right center;
        animation: rino-chat-line-in-right 0.3s ease-out 0.9s forwards;
    }

    .rino-chat-staff-line-2 {
        opacity: 0;
        transform-origin: right center;
        animation: rino-chat-line-in-right 0.3s ease-out 1.02s forwards;
    }

    @media (prefers-reduced-motion: reduce) {
        .rino-chat-customer,
        .rino-chat-staff,
        .rino-chat-customer-line-1,
        .rino-chat-customer-line-2,
        .rino-chat-staff-line-1,
        .rino-chat-staff-line-2 {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }
</style>

<div
    style="
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        font-family: var(--font-body);
        color: var(--text-body);
    "
>
    <div
        style="
            width: 100%;
            max-width: 440px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        "
    >
        <div
            class="rino-chat-customer"
            style="
                display: flex;
                align-items: flex-start;
                gap: 10px;
            "
        >
            <img
                src="/assets/avatars/user.jpg"
                alt="Customer"
                style="
                    width: 38px;
                    height: 38px;
                    flex-shrink: 0;
                    display: block;
                    margin-top: 3px;
                    border-radius: 9999px;
                    object-fit: cover;
                    background: var(--surface-secondary);
                "
            >

            <div
                style="
                    position: relative;
                    flex: 1;
                    min-width: 0;
                    max-width: 84%;
                    padding: 13px 15px;
                    border-radius: 14px;
                    background: var(--surface-secondary);
                "
            >
                <span
                    style="
                        position: absolute;
                        top: 14px;
                        left: -7px;
                        width: 0;
                        height: 0;
                        border-top: 7px solid transparent;
                        border-bottom: 7px solid transparent;
                        border-right: 8px solid var(--surface-secondary);
                    "
                ></span>

                <div
                    style="
                        position: relative;
                        z-index: 1;
                        margin-bottom: 9px;
                        font-size: 12px;
                        line-height: 1;
                        font-weight: 700;
                        color: var(--text-heading);
                    "
                >
                    Customer
                </div>

                <div
                    style="
                        position: relative;
                        z-index: 1;
                        display: flex;
                        flex-direction: column;
                        gap: 7px;
                    "
                >
                    <div
                        class="rino-chat-customer-line-1"
                        style="
                            width: 88%;
                            height: 9px;
                            border-radius: 9999px;
                            background: color-mix(
                                in srgb,
                                var(--text-muted) 22%,
                                transparent
                            );
                        "
                    ></div>

                    <div
                        class="rino-chat-customer-line-2"
                        style="
                            width: 58%;
                            height: 9px;
                            border-radius: 9999px;
                            background: color-mix(
                                in srgb,
                                var(--text-muted) 16%,
                                transparent
                            );
                        "
                    ></div>
                </div>
            </div>
        </div>

        <div
            class="rino-chat-staff"
            style="
                display: flex;
                align-items: flex-start;
                justify-content: flex-end;
                gap: 10px;
            "
        >
            <div
                style="
                    position: relative;
                    flex: 1;
                    min-width: 0;
                    max-width: 84%;
                    padding: 13px 15px;
                    border-radius: 14px;
                    background: var(--surface-secondary);
                "
            >
                <span
                    style="
                        position: absolute;
                        top: 14px;
                        right: -7px;
                        width: 0;
                        height: 0;
                        border-top: 7px solid transparent;
                        border-bottom: 7px solid transparent;
                        border-left: 8px solid var(--surface-secondary);
                    "
                ></span>

                <div
                    style="
                        position: relative;
                        z-index: 1;
                        margin-bottom: 9px;
                        text-align: right;
                        font-size: 12px;
                        line-height: 1;
                        font-weight: 700;
                        color: var(--text-heading);
                    "
                >
                    Staff
                </div>

                <div
                    style="
                        position: relative;
                        z-index: 1;
                        display: flex;
                        flex-direction: column;
                        gap: 7px;
                    "
                >
                    <div
                        class="rino-chat-staff-line-1"
                        style="
                            width: 90%;
                            height: 9px;
                            margin-left: auto;
                            border-radius: 9999px;
                            background: color-mix(
                                in srgb,
                                var(--text-muted) 22%,
                                transparent
                            );
                        "
                    ></div>

                    <div
                        class="rino-chat-staff-line-2"
                        style="
                            width: 70%;
                            height: 9px;
                            margin-left: auto;
                            border-radius: 9999px;
                            background: color-mix(
                                in srgb,
                                var(--text-muted) 16%,
                                transparent
                            );
                        "
                    ></div>
                </div>
            </div>

            <img
                src="/assets/avatars/admin.jpg"
                alt="Staff"
                style="
                    width: 38px;
                    height: 38px;
                    flex-shrink: 0;
                    display: block;
                    margin-top: 3px;
                    border-radius: 9999px;
                    object-fit: cover;
                    background: var(--surface-secondary);
                "
            >
        </div>
    </div>
</div>
RINO_EMBED_HTML,
                    ],
                    [
                        'id' => 'home-feature-4',
                        'enabled' => true,
                        'title' => 'Reliable Uptime',
                        'description' => 'Stable infrastructure keeps your server ready for players.',
                        'visual_type' => 'html',
                        'image' => null,
                        'html' => <<<'RINO_EMBED_HTML'

<style>
    .rino-uptime-visual {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 220px;
        overflow: hidden;
        box-sizing: border-box;
        font-family: var(--font-body);
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 16px;
        padding: 10px 8px 12px;
    }

    .rino-uptime-background-grid {
        position: absolute;
        top: 18px;
        right: 0;
        bottom: 4px;
        left: 0;
        z-index: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
        opacity: 0.32;
    }

    .rino-uptime-grid-line {
        width: 100%;
        border-top: 1px solid var(--border);
    }

    .rino-uptime-badges {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 58px;
        flex: 0 0 58px;
    }

    .rino-uptime-badge {
        position: absolute;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 5px 8px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--surface);
        color: var(--text-heading);
        white-space: nowrap;
        box-shadow: none;
    }

    .rino-uptime-badge-dot {
        width: 6px;
        height: 6px;
        flex: 0 0 6px;
        border-radius: 999px;
        background: var(--primary);
    }

    .rino-uptime-badge-text {
        color: var(--text-heading);
        font-size: 10px;
        line-height: 1;
        font-weight: 600;
        letter-spacing: 0.01em;
    }

    .rino-uptime-grid-wrap {
        position: relative;
        z-index: 1;
        width: 100%;
        flex: 1;
        min-height: 126px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        overflow: hidden;
    }

    .rino-uptime-bars {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 126px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 3px;
        padding: 5px 2px 10px;
        box-sizing: border-box;
    }

    .rino-uptime-visual .rino-uptime-bar {
        width: 7px;
        flex: 0 0 7px;
        margin: 0;
        border-radius: 999px;
        background: var(--primary);
        opacity: 0.88;
    }

    .rino-uptime-visual .rino-uptime-bar--downtime {
        background: var(--surface-secondary);
        opacity: 1;
    }

    @media (max-width: 640px) {
        .rino-uptime-visual {
            gap: 13px;
        }

        .rino-uptime-badges {
            height: 54px;
            flex-basis: 54px;
        }

        .rino-uptime-badge {
            padding: 4px 7px;
        }

        .rino-uptime-badge-text {
            font-size: 9px;
        }

        .rino-uptime-bars {
            gap: 2.5px;
        }

        .rino-uptime-visual .rino-uptime-bar {
            width: 6px;
            flex-basis: 6px;
        }
    }
</style>

<div class="rino-uptime-visual" data-rino-uptime>
    <div class="rino-uptime-background-grid">
        <div class="rino-uptime-grid-line"></div>
        <div class="rino-uptime-grid-line"></div>
        <div class="rino-uptime-grid-line"></div>
        <div class="rino-uptime-grid-line"></div>
        <div class="rino-uptime-grid-line"></div>
        <div class="rino-uptime-grid-line"></div>
        <div class="rino-uptime-grid-line"></div>
    </div>

    <div class="rino-uptime-badges">
        <div
            class="rino-uptime-badge"
            style="top: 4px; left: 7%;"
        >
            <span class="rino-uptime-badge-dot"></span>
            <span class="rino-uptime-badge-text">
                99.99% Uptime
            </span>
        </div>

        <div
            class="rino-uptime-badge"
            style="top: 29px; left: 37%;"
        >
            <span class="rino-uptime-badge-dot"></span>
            <span class="rino-uptime-badge-text">
                99.9% Uptime
            </span>
        </div>

        <div
            class="rino-uptime-badge"
            style="top: 0; right: 8%;"
        >
            <span class="rino-uptime-badge-dot"></span>
            <span class="rino-uptime-badge-text">
                99.98% Uptime
            </span>
        </div>
    </div>

    <div class="rino-uptime-grid-wrap">
        <div
            class="rino-uptime-bars"
            data-rino-uptime-bars
        ></div>
    </div>
</div>

<script>
(() => {
    const script = document.currentScript;
    const wrapper = script?.previousElementSibling;

    if (!wrapper) {
        return;
    }

    const grid = wrapper.querySelector(
        '[data-rino-uptime-bars]'
    );

    if (!grid) {
        return;
    }

    const totalBars = 34;

    const downtimeIndices = [
        6,
        15,
        24,
        31
    ];

    const baseHeights = [
        70,
        79,
        75,
        86,
        73,
        82,
        77,
        89,
        68,
        81,
        85,
        74,
        88,
        79,
        84,
        72,
        90,
        78,
        83,
        76,
        87,
        71,
        81,
        85,
        67,
        80,
        88,
        75,
        83,
        78,
        89,
        73,
        82,
        77
    ];

    grid.innerHTML = '';

    for (let i = 0; i < totalBars; i++) {
        const bar = document.createElement('div');

        const isDowntime =
            downtimeIndices.includes(i);

        bar.className = 'rino-uptime-bar';

        if (isDowntime) {
            bar.classList.add(
                'rino-uptime-bar--downtime'
            );
        }

        const height =
            baseHeights[i % baseHeights.length];

        bar.style.height = `${height}px`;

        grid.appendChild(bar);
    }
})();
</script>

RINO_EMBED_HTML,
                    ],
                    [
                        'id' => 'home-feature-5',
                        'enabled' => true,
                        'title' => 'Dedicated Hardware',
                        'description' => 'Consistent server hardware with no hidden downgrades.',
                        'visual_type' => 'html',
                        'image' => null,
                        'html' => <<<'RINO_EMBED_HTML'
<div class="rino-processor-visual">
    <canvas
        class="rino-processor-waves"
        data-processor-waves
        aria-hidden="true"
    ></canvas>

    <div class="rino-processor-images">
        <img
            src="/assets/processors/intel.png"
            alt="Intel Processor"
            class="rino-processor-image"
        >

        <img
            src="/assets/processors/amd.png"
            alt="AMD Processor"
            class="rino-processor-image"
        >
    </div>

    <style>
        .rino-processor-visual {
            position: relative;
            width: 100%;
            min-height: 300px;
            overflow: hidden;
        }

        .rino-processor-waves {
            position: absolute;
            inset: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            transform: translateY(-26px);
        }

        .rino-processor-images {
            position: relative;
            z-index: 1;

            display: flex;
            min-height: 300px;

            align-items: flex-start;
            justify-content: center;

            gap: 2.25rem;

            padding:
                4.6rem
                1.5rem
                1.5rem;
        }

        .rino-processor-image {
            display: block;

            width: auto;
            height: auto;

            max-width: 96px;
            max-height: 96px;

            object-fit: contain;

            border-radius: 14px;
        }

        @media (max-width: 640px) {
            .rino-processor-visual,
            .rino-processor-images {
                min-height: 260px;
            }

            .rino-processor-waves {
                transform: translateY(-22px);
            }

            .rino-processor-images {
                gap: 1.5rem;

                padding:
                    4rem
                    1rem
                    1.25rem;
            }

            .rino-processor-image {
                max-width: 82px;
                max-height: 82px;
                border-radius: 12px;
            }
        }
    </style>

    <script>
        (() => {
            const visual =
                document.currentScript.closest(
                    '.rino-processor-visual'
                );

            if (!visual) {
                return;
            }

            const canvas =
                visual.querySelector(
                    '[data-processor-waves]'
                );

            if (!canvas) {
                return;
            }

            const ctx =
                canvas.getContext('2d');

            function drawStaticWaves() {
                const rect =
                    visual.getBoundingClientRect();

                const width =
                    rect.width;

                const height =
                    rect.height;

                const ratio =
                    window.devicePixelRatio || 1;

                canvas.width =
                    width * ratio;

                canvas.height =
                    height * ratio;

                canvas.style.width =
                    width + 'px';

                canvas.style.height =
                    height + 'px';

                ctx.setTransform(
                    ratio,
                    0,
                    0,
                    ratio,
                    0,
                    0
                );

                ctx.clearRect(
                    0,
                    0,
                    width,
                    height
                );

                const numWaves = 12;

                ctx.fillStyle =
                    'rgba(148, 163, 184, 0.24)';

                const frequency =
                    0.008;

                const amplitude =
                    40;

                for (
                    let w = 0;
                    w < numWaves;
                    w++
                ) {
                    const centerY =
                        (
                            height /
                            (numWaves + 1)
                        ) *
                        (w + 1);

                    const phase = 0;

                    for (
                        let x = 0;
                        x < width;
                        x += 18
                    ) {
                        const y =
                            centerY +
                            Math.sin(
                                x * frequency +
                                phase
                            ) *
                            amplitude;

                        ctx.beginPath();

                        ctx.arc(
                            x,
                            y,
                            1.1,
                            0,
                            Math.PI * 2
                        );

                        ctx.fill();
                    }
                }
            }

            drawStaticWaves();

            const observer =
                new ResizeObserver(
                    drawStaticWaves
                );

            observer.observe(
                visual
            );
        })();
    </script>
</div>
RINO_EMBED_HTML,
                    ],
                    [
                        'id' => 'home-feature-6',
                        'enabled' => true,
                        'title' => 'Simple Mod Management',
                        'description' => 'Manage compatible plugins and mods from your panel.',
                        'visual_type' => 'html',
                        'image' => null,
                        'html' => <<<'RINO_EMBED_HTML'
<div class="rino-plugin-visual">
    <style>
        .rino-plugin-visual {
            width: 100%;
            height: 100%;
            min-height: 270px;

            display: flex;
            overflow: hidden;

            border: 2px solid var(--border);
            border-radius: var(--radius-card);

            background: var(--surface);
            color: var(--text-body);

            font-family: inherit;
        }

        .rino-plugin-visual,
        .rino-plugin-visual * {
            box-sizing: border-box;
        }

        .rino-plugin-sidebar {
            width: 132px;
            flex: 0 0 132px;

            padding: 1rem 0.55rem;

            background: var(--surface);
        }

        .rino-plugin-panel-title {
            margin: 0 0 1.15rem;
            padding: 0 0.55rem;

            color: var(--text-heading);

            font-size: 0.78rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .rino-plugin-nav {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .rino-plugin-nav-item {
            position: relative;

            display: flex;
            min-height: 30px;

            align-items: center;
            gap: 0.5rem;

            padding:
                0.45rem
                0.55rem;

            border-radius: 0.5rem;

            color: var(--text-muted);

            font-size: 0.64rem;
            font-weight: 500;
        }

        .rino-plugin-nav-item.active {
            padding-left: 0.85rem;

            border-radius:
                0
                0.5rem
                0.5rem
                0;

            background:
                color-mix(
                    in srgb,
                    var(--primary) 12%,
                    var(--surface-secondary)
                );

            color: var(--primary);
        }

        .rino-plugin-nav-item.active::before {
            content: "";

            position: absolute;

            top: 0;
            bottom: 0;
            left: 0;

            width: 4px;

            background: var(--primary);
        }

        .rino-plugin-nav-icon {
            width: 13px;
            height: 13px;
            flex: 0 0 13px;
        }

        .rino-plugin-main {
            min-width: 0;
            flex: 1;

            padding: 1rem;

            background: var(--background);
        }

        .rino-plugin-search {
            display: flex;
            height: 34px;

            align-items: center;
            gap: 0.55rem;

            padding: 0 0.75rem;

            border-radius: 0.7rem;

            background: var(--surface-secondary);
        }

        .rino-plugin-search svg {
            width: 13px;
            height: 13px;
            flex: 0 0 13px;

            color: var(--text-muted);
        }

        .rino-plugin-search-line {
            width: 58%;
            height: 6px;

            border-radius: 999px;

            background:
                color-mix(
                    in srgb,
                    var(--text-muted) 24%,
                    transparent
                );
        }

        .rino-plugin-card {
            margin-top: 0.9rem;
            padding: 0.9rem;

            border-radius: 0.9rem;

            background: var(--surface);
        }

        .rino-plugin-card-top {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .rino-plugin-icon {
            display: flex;

            width: 40px;
            height: 40px;
            flex: 0 0 40px;

            align-items: center;
            justify-content: center;

            border-radius: 0.7rem;

            background: var(--primary);
            color: var(--primary-text);
        }

        .rino-plugin-icon svg {
            width: 20px;
            height: 20px;
        }

        .rino-plugin-heading-lines {
            display: flex;
            min-width: 0;
            flex: 1;

            flex-direction: column;
            gap: 0.45rem;
        }

        .rino-plugin-line {
            height: 7px;

            border-radius: 999px;

            background:
                color-mix(
                    in srgb,
                    var(--text-muted) 24%,
                    transparent
                );
        }

        .rino-plugin-line.strong {
            background:
                color-mix(
                    in srgb,
                    var(--text-heading) 30%,
                    transparent
                );
        }

        .rino-plugin-line.title {
            width: 66%;
            height: 8px;
        }

        .rino-plugin-line.short {
            width: 42%;
        }

        .rino-plugin-line.medium {
            width: 72%;
        }

        .rino-plugin-line.long {
            width: 92%;
        }

        .rino-plugin-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;

            margin-top: 0.85rem;
            padding: 0.55rem 0.65rem;

            border-radius: 0.55rem;

            background: var(--surface-secondary);
        }

        .rino-plugin-meta-item {
            display: flex;
            flex: 1 1 0;

            align-items: center;
            gap: 0.35rem;
        }

        .rino-plugin-meta-item svg {
            width: 10px;
            height: 10px;
            flex: 0 0 10px;

            color: var(--text-muted);
        }

        .rino-plugin-meta-line {
            width: 100%;
            max-width: 42px;
            height: 5px;

            border-radius: 999px;

            background:
                color-mix(
                    in srgb,
                    var(--text-muted) 22%,
                    transparent
                );
        }

        .rino-plugin-body {
            display: flex;
            flex-direction: column;

            gap: 0.5rem;

            margin-top: 0.85rem;
        }

        .rino-plugin-status {
            display: inline-flex;
            width: fit-content;

            align-items: center;
            gap: 0.35rem;

            margin-top: 0.9rem;
            padding: 0.42rem 0.65rem;

            border-radius: 0.5rem;

            background:
                color-mix(
                    in srgb,
                    var(--primary) 11%,
                    var(--surface-secondary)
                );
        }

        .rino-plugin-status svg {
            width: 11px;
            height: 11px;

            color: var(--primary);
        }

        .rino-plugin-status-line {
            width: 42px;
            height: 5px;

            border-radius: 999px;

            background:
                color-mix(
                    in srgb,
                    var(--primary) 48%,
                    transparent
                );
        }

        @media (max-width: 640px) {
            .rino-plugin-visual {
                min-height: 245px;
            }

            .rino-plugin-sidebar {
                width: 108px;
                flex-basis: 108px;

                padding-inline: 0.4rem;
            }

            .rino-plugin-panel-title {
                padding-inline: 0.4rem;

                font-size: 0.7rem;
            }

            .rino-plugin-nav-item {
                padding-inline: 0.4rem;

                font-size: 0.56rem;
            }

            .rino-plugin-nav-item.active {
                padding-left: 0.72rem;
            }

            .rino-plugin-main {
                padding: 0.75rem;
            }

            .rino-plugin-card {
                padding: 0.75rem;
            }

            .rino-plugin-meta {
                gap: 0.4rem;
            }
        }
    </style>

    <aside class="rino-plugin-sidebar">
        <div class="rino-plugin-panel-title">
            Game Panel
        </div>

        <div class="rino-plugin-nav">
            <div class="rino-plugin-nav-item active">
                <svg
                    class="rino-plugin-nav-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M19.4 15a1.7 1.7 0 0 0 1.6-1.7V9.7A1.7 1.7 0 0 0 19.3 8H16V4.7A1.7 1.7 0 0 0 14.3 3h-3.6A1.7 1.7 0 0 0 9 4.7V8H5.7A1.7 1.7 0 0 0 4 9.7v3.6A1.7 1.7 0 0 0 5.7 15H9v3.3a1.7 1.7 0 0 0 1.7 1.7h3.6a1.7 1.7 0 0 0 1.7-1.7V15Z"/>
                </svg>

                Plugins
            </div>

            <div class="rino-plugin-nav-item">
                <svg
                    class="rino-plugin-nav-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="m12 2 9 5-9 5-9-5 9-5Z"/>
                    <path d="m3 12 9 5 9-5"/>
                    <path d="m3 17 9 5 9-5"/>
                </svg>

                Mods
            </div>

            <div class="rino-plugin-nav-item">
                <svg
                    class="rino-plugin-nav-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M3 7h5l2 2h11v10H3Z"/>
                    <path d="M3 7V5h6l2 2"/>
                </svg>

                Files
            </div>

            <div class="rino-plugin-nav-item">
                <svg
                    class="rino-plugin-nav-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <ellipse cx="12" cy="5" rx="8" ry="3"/>
                    <path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5"/>
                    <path d="M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>
                </svg>

                Databases
            </div>

            <div class="rino-plugin-nav-item">
                <svg
                    class="rino-plugin-nav-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <rect x="3" y="4" width="18" height="5" rx="1"/>
                    <rect x="3" y="15" width="18" height="5" rx="1"/>
                    <path d="M7 9v6"/>
                    <path d="M17 9v6"/>
                </svg>

                Backups
            </div>

            <div class="rino-plugin-nav-item">
                <svg
                    class="rino-plugin-nav-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M3 12h18"/>
                    <path d="M12 3a15 15 0 0 1 0 18"/>
                    <path d="M12 3a15 15 0 0 0 0 18"/>
                </svg>

                Network
            </div>
        </div>
    </aside>

    <div class="rino-plugin-main">
        <div class="rino-plugin-search">
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-3.5-3.5"/>
            </svg>

            <div class="rino-plugin-search-line"></div>
        </div>

        <div class="rino-plugin-card">
            <div class="rino-plugin-card-top">
                <div class="rino-plugin-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M19.4 15a1.7 1.7 0 0 0 1.6-1.7V9.7A1.7 1.7 0 0 0 19.3 8H16V4.7A1.7 1.7 0 0 0 14.3 3h-3.6A1.7 1.7 0 0 0 9 4.7V8H5.7A1.7 1.7 0 0 0 4 9.7v3.6A1.7 1.7 0 0 0 5.7 15H9v3.3a1.7 1.7 0 0 0 1.7 1.7h3.6a1.7 1.7 0 0 0 1.7-1.7V15Z"/>
                    </svg>
                </div>

                <div class="rino-plugin-heading-lines">
                    <div class="rino-plugin-line strong title"></div>
                    <div class="rino-plugin-line short"></div>
                </div>
            </div>

            <div class="rino-plugin-meta">
                <div class="rino-plugin-meta-item">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M12 3v12"/>
                        <path d="m7 10 5 5 5-5"/>
                        <path d="M5 21h14"/>
                    </svg>

                    <div class="rino-plugin-meta-line"></div>
                </div>

                <div class="rino-plugin-meta-item">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2 7.5 14 3 9.6l6.2-.9Z"/>
                    </svg>

                    <div class="rino-plugin-meta-line"></div>
                </div>

                <div class="rino-plugin-meta-item">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>

                    <div class="rino-plugin-meta-line"></div>
                </div>
            </div>

            <div class="rino-plugin-body">
                <div class="rino-plugin-line long"></div>
                <div class="rino-plugin-line medium"></div>
            </div>

            <div class="rino-plugin-status">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="m5 12 4 4L19 6"/>
                </svg>

                <div class="rino-plugin-status-line"></div>
            </div>
        </div>
    </div>
</div>
RINO_EMBED_HTML,
                    ],
                ],
            ],
        ],
        [
            'type' => 'locations',
            'data' => [
                'enabled' => true,
                'alignment' => 'center',
                'heading' => 'Deploy closer to your users',
                'description' => 'Choose infrastructure nearer to your audience for lower latency and a smoother experience.',
                'layout' => 'map-list',
                'locations' => [
                    [
                        'id' => 'home-location-sg',
                        'enabled' => true,
                        'location' => 'singapore',
                        'label' => 'Singapore, Singapore',
                        'status' => 'available',
                    ],
                    [
                        'id' => 'home-location-nl',
                        'enabled' => true,
                        'location' => 'amsterdam',
                        'label' => 'Amsterdam, Netherlands',
                        'status' => 'available',
                    ],
                    [
                        'id' => 'home-location-us',
                        'enabled' => true,
                        'location' => 'chicago',
                        'label' => 'Chicago, United States',
                        'status' => 'available',
                    ],
                    [
                        'id' => 'home-location-de',
                        'enabled' => true,
                        'location' => 'frankfurt',
                        'label' => 'Frankfurt, Germany',
                        'status' => 'available',
                    ],
                ],
            ],
        ],
        [
            'type' =>
                'faq',

            'data' => [
                'enabled' =>
                    true,

                'alignment' =>
                    'center',

                'heading' =>
                    'Hosting made straightforward',

                'description' =>
                    'Answers to common questions about getting started with Rino hosting.',

                'layout' =>
                    'centered',

                'questions' => [
                    [
                        'id' =>
                            'home-hosting-types',

                        'enabled' =>
                            true,

                        'question' =>
                            'What types of hosting are available?',

                        'answer' =>
                            'Rino can present game hosting, VPS hosting, web hosting, bot hosting, and other services configured by the hosting provider.',
                    ],

                    [
                        'id' =>
                            'home-upgrade',

                        'enabled' =>
                            true,

                        'question' =>
                            'Can I upgrade later?',

                        'answer' =>
                            'Yes. Available plans can be configured so customers can move to larger resources as their project grows.',
                    ],

                    [
                        'id' =>
                            'home-currency',

                        'enabled' =>
                            true,

                        'question' =>
                            'Can prices be shown in different currencies?',

                        'answer' =>
                            'Yes. Rino supports multiple enabled currencies and can display plan prices using the selected currency.',
                    ],

                    [
                        'id' =>
                            'home-support',

                        'enabled' =>
                            true,

                        'question' =>
                            'Where can customers get help?',

                        'answer' =>
                            'Hosting providers can connect their client area, support system, documentation, and knowledge base directly from the website.',
                    ],
                ],
            ],
        ],

        [
            'type' =>
                'cta',

            'data' => [
                'enabled' =>
                    true,

                'alignment' =>
                    'center',

                'layout' =>
                    'centered',

                'heading' =>
                    'Ready to get your project online?',

                'description' =>
                    'Explore the available hosting services and choose the resources that fit your project.',

                'primary_button_enabled' =>
                    true,

                'primary_button_label' =>
                    'Explore Hosting',

                'primary_button_url' =>
                    '/minecraft-hosting',

                'primary_button_style' =>
                    'icon-circle',

                'primary_button_icon' =>
                    'arrow-right',

                'secondary_button_enabled' =>
                    false,
            ],
        ],
    ],
];