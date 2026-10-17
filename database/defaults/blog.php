<?php

return [
    'page' => [
        'default_key' => 'blog',
        'title' => 'Blog',
        'slug' => 'blog',
        'category' => 'resources',
        'template' => 'blog',
        'page_type' => 'structured',
        'short_description' => 'Hosting guides, server tutorials, performance tips, and practical resources from Rino.',
        'active' => true,
        'published' => true,
        'system_page' => false,
        'show_in_header' => true,
        'show_in_footer' => true,
        'sort_order' => 100,
    ],

    'settings' => [
        'blog_page_title' => [
            'value' => 'Blog',
            'type' => 'text',
        ],

        'blog_slug' => [
            'value' => 'blog',
            'type' => 'text',
        ],

        'blog_description' => [
            'value' => 'Hosting guides, server tutorials, performance tips, and practical resources from Rino.',
            'type' => 'textarea',
        ],

        'blog_hero_enabled' => [
            'value' => '1',
            'type' => 'boolean',
        ],

        'blog_hero_eyebrow' => [
            'value' => 'Resources',
            'type' => 'text',
        ],

        'blog_hero_heading' => [
            'value' => 'Hosting guides & insights',
            'type' => 'text',
        ],

        'blog_hero_description' => [
            'value' => 'Practical guides, tutorials, and tips for hosting, servers, performance, and security.',
            'type' => 'textarea',
        ],

        'blog_hero_background_image' => [
            'value' => 'assets/hero-bg/kb-blog.webp',
            'type' => 'image',
        ],

        'blog_hero_alignment' => [
            'value' => 'center',
            'type' => 'text',
        ],

        'blog_seo_title' => [
            'value' => 'Rino Hosting Blog',
            'type' => 'text',
        ],

        'blog_seo_description' => [
            'value' => 'Read practical hosting guides, Minecraft server tutorials, VPS advice, performance tips, and infrastructure resources from Rino.',
            'type' => 'textarea',
        ],
    ],

    'tags' => [
        'guides' => [
            'name' => 'Guides',
            'slug' => 'guides',
            'enabled' => true,
            'sort_order' => 10,
        ],

        'hosting' => [
            'name' => 'Hosting',
            'slug' => 'hosting',
            'enabled' => true,
            'sort_order' => 20,
        ],

        'minecraft' => [
            'name' => 'Minecraft',
            'slug' => 'minecraft',
            'enabled' => true,
            'sort_order' => 30,
        ],

        'performance' => [
            'name' => 'Performance',
            'slug' => 'performance',
            'enabled' => true,
            'sort_order' => 40,
        ],

        'security' => [
            'name' => 'Security',
            'slug' => 'security',
            'enabled' => true,
            'sort_order' => 50,
        ],
    ],

    'posts' => [
        'choosing-plan' => [
            'title' => 'How to Choose the Right Hosting Plan',
            'slug' => 'how-to-choose-the-right-hosting-plan',
            'excerpt' => 'Learn how to choose CPU, RAM, storage, and bandwidth based on your website, application, or game server workload.',

            'content' =>
                '<p>Choosing the right hosting plan is less about buying the biggest package and more about matching resources to the workload you actually run.</p>'
                . '<h2>Start with the workload</h2>'
                . '<p>A simple portfolio website has very different requirements from an online store, a busy web application, or a multiplayer game server. Before comparing plans, identify what software you will run, how many users you expect, and how quickly that demand may grow.</p>'
                . '<h2>Understand CPU and RAM</h2>'
                . '<p>CPU resources affect how quickly your server can process requests, while RAM determines how much active data and how many processes can remain available at once. Applications with databases, plugins, background jobs, or many simultaneous users generally require more of both.</p>'
                . '<h2>Do not ignore storage</h2>'
                . '<p>NVMe storage can significantly improve loading times, database operations, server startup, and file access compared with slower storage technologies. Capacity matters, but storage speed matters too.</p>'
                . '<h2>Leave room to grow</h2>'
                . '<p>You do not need to overpay for resources you may never use, but running permanently at the limit is not ideal either. Choose a plan that comfortably handles your normal workload and gives you some room for traffic spikes and future growth.</p>'
                . '<p>The best hosting plan is the one that gives your project enough resources today while allowing an easy upgrade path tomorrow.</p>',

            'author' => 'Rino',
            'published_date' => null,
            'read_time' => 5,
            'published' => true,

            'seo_title' => 'How to Choose the Right Hosting Plan',

            'seo_description' => 'Learn how to choose the right hosting plan based on CPU, RAM, storage, traffic, and expected workload.',

            'tags' => [
                'guides',
                'hosting',
            ],
        ],

        'minecraft-lag' => [
            'title' => 'How to Reduce Lag on a Minecraft Server',
            'slug' => 'how-to-reduce-lag-on-a-minecraft-server',

            'excerpt' => 'A practical guide to improving Minecraft server performance by managing plugins, view distance, hardware resources, and world activity.',

            'content' =>
                '<p>Minecraft server lag is usually caused by a combination of limited hardware resources, demanding plugins, large amounts of world activity, or settings that are too aggressive for the server.</p>'
                . '<h2>Check server TPS first</h2>'
                . '<p>Ticks per second are one of the clearest indicators of server performance. A healthy server normally aims to stay close to 20 TPS. Sustained drops indicate that the server is taking too long to process each game tick.</p>'
                . '<h2>Reduce unnecessary plugins</h2>'
                . '<p>Every plugin adds work to the server. Poorly optimized plugins can create expensive database queries, excessive entity scans, repeated tasks, or unnecessary file operations. Remove plugins you no longer use and keep important plugins updated.</p>'
                . '<h2>Control view and simulation distance</h2>'
                . '<p>High view distance and simulation distance values increase the number of chunks the server must load and process. Lowering them slightly can provide a major performance improvement on busy servers without significantly affecting normal gameplay.</p>'
                . '<h2>Watch entities and farms</h2>'
                . '<p>Large mob farms, excessive dropped items, villagers, redstone machines, and continuously loaded chunks can consume significant processing time. Sensible limits and regular monitoring help prevent individual areas from slowing down the entire server.</p>'
                . '<h2>Use suitable hardware</h2>'
                . '<p>Minecraft benefits heavily from strong CPU performance, sufficient RAM, and fast storage. Adding more RAM does not solve every performance problem, but a server without enough memory will struggle as the player count, world size, and plugin load increase.</p>'
                . '<p>Performance tuning works best when you measure the real bottleneck first and then make targeted changes instead of changing every setting at once.</p>',

            'author' => 'Rino',
            'published_date' => null,
            'read_time' => 6,
            'published' => true,

            'seo_title' => 'How to Reduce Lag on a Minecraft Server',

            'seo_description' => 'Improve Minecraft server performance with practical tips for TPS, plugins, chunks, entities, RAM, and server hardware.',

            'tags' => [
                'minecraft',
                'performance',
                'guides',
            ],
        ],

        'vps-vs-shared' => [
            'title' => 'VPS vs Shared Hosting: What Is the Difference?',
            'slug' => 'vps-vs-shared-hosting',

            'excerpt' => 'Understand the difference between shared hosting and a VPS, and learn which option makes more sense for your project.',

            'content' =>
                '<p>Shared hosting and virtual private servers can both host websites, but they give you very different levels of control, isolation, and responsibility.</p>'
                . '<h2>What is shared hosting?</h2>'
                . '<p>Shared hosting places multiple customers on a managed hosting environment. The hosting provider handles most server administration, while customers manage their websites through a control panel or similar interface.</p>'
                . '<p>It is usually a good fit for small websites, portfolios, blogs, and projects where simplicity matters more than complete server control.</p>'
                . '<h2>What is a VPS?</h2>'
                . '<p>A VPS gives you an isolated virtual server with allocated resources and much greater control over the operating system and software stack. Depending on the service, you may receive full root access and the ability to install custom applications, services, databases, and server software.</p>'
                . '<h2>Control versus convenience</h2>'
                . '<p>Shared hosting is easier to manage because many infrastructure decisions are already handled for you. A self-managed VPS offers far more freedom, but that freedom also means you are responsible for updates, security, configuration, backups, and troubleshooting.</p>'
                . '<h2>Which should you choose?</h2>'
                . '<p>Choose shared hosting when you want a straightforward environment for a standard website. Choose a VPS when you need custom software, dedicated allocations, development environments, game servers, application hosting, or greater control over the stack.</p>'
                . '<p>The better choice depends on your technical requirements rather than simply choosing the more powerful product.</p>',

            'author' => 'Rino',
            'published_date' => null,
            'read_time' => 5,
            'published' => true,

            'seo_title' => 'VPS vs Shared Hosting: What Is the Difference?',

            'seo_description' => 'Compare VPS and shared hosting to understand the differences in control, resources, management, and ideal use cases.',

            'tags' => [
                'hosting',
                'guides',
            ],
        ],

        'server-backups' => [
            'title' => 'Why Server Backups Matter More Than You Think',
            'slug' => 'why-server-backups-matter',

            'excerpt' => 'Hardware failure, bad updates, accidental deletion, and compromised accounts can happen. A reliable backup strategy keeps one incident from becoming a disaster.',

            'content' =>
                '<p>A server can run perfectly for months and still lose important data in minutes. Backups are what separate an inconvenient failure from a permanent loss.</p>'
                . '<h2>Servers can fail</h2>'
                . '<p>Modern infrastructure is reliable, but no storage device, operating system, application, or administrator is immune to failure. Hardware issues, filesystem corruption, accidental deletion, faulty updates, malware, and configuration mistakes can all damage important data.</p>'
                . '<h2>A snapshot is not always a complete backup strategy</h2>'
                . '<p>Snapshots are useful for quick recovery, but important data should also have independent copies. If the original infrastructure or account is compromised, backups stored in the same place may be affected as well.</p>'
                . '<h2>Follow the 3-2-1 principle</h2>'
                . '<p>A practical backup strategy keeps at least three copies of important data, stores them on at least two different types of storage or locations, and keeps at least one copy separate from the primary server.</p>'
                . '<h2>Backups must be tested</h2>'
                . '<p>A backup that cannot be restored is not useful. Periodically verify that archives are readable, databases can be recovered, and the restoration process is documented.</p>'
                . '<h2>Automate whenever possible</h2>'
                . '<p>Automated daily or scheduled backups reduce the chance that someone simply forgets to create one. The frequency should depend on how much data you can realistically afford to lose between backups.</p>'
                . '<p>Whether you run a website, database, VPS, or game server, backups should be treated as part of the infrastructure rather than an optional extra.</p>',

            'author' => 'Rino',
            'published_date' => null,
            'read_time' => 5,
            'published' => true,

            'seo_title' => 'Why Server Backups Matter More Than You Think',

            'seo_description' => 'Learn why server backups matter, how the 3-2-1 backup principle works, and why testing your recovery process is essential.',

            'tags' => [
                'security',
                'hosting',
                'guides',
            ],
        ],
    ],
];