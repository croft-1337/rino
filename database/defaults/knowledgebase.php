<?php

return [
    'page' => [
        'default_key' => 'knowledgebase',
        'title' => 'Knowledge Base',
        'slug' => 'knowledgebase',
        'category' => 'resources',
        'template' => 'knowledgebase',
        'page_type' => 'structured',
        'short_description' => 'Find answers, tutorials, and help for your Rino services.',
        'active' => true,
        'published' => true,
        'system_page' => false,
        'show_in_header' => true,
        'show_in_footer' => true,
        'sort_order' => 110,
    ],

    'settings' => [
        'knowledgebase_page_title' => [
            'value' => 'Knowledge Base',
            'type' => 'text',
        ],

        'knowledgebase_slug' => [
            'value' => 'knowledgebase',
            'type' => 'text',
        ],

        'knowledgebase_description' => [
            'value' => 'Find answers, tutorials, and help for your Rino services.',
            'type' => 'textarea',
        ],

        'knowledgebase_hero_enabled' => [
            'value' => '1',
            'type' => 'boolean',
        ],

        'knowledgebase_hero_alignment' => [
            'value' => 'center',
            'type' => 'text',
        ],

        'knowledgebase_hero_eyebrow' => [
            'value' => 'Support',
            'type' => 'text',
        ],

        'knowledgebase_hero_heading' => [
            'value' => 'How can we help?',
            'type' => 'text',
        ],

        'knowledgebase_hero_description' => [
            'value' => 'Search our documentation or browse a category to find the help you need.',
            'type' => 'textarea',
        ],

        'knowledgebase_hero_background_image' => [
            'value' => 'assets/hero-bg/kb-blog.webp',
            'type' => 'image',
        ],

        'knowledgebase_seo_title' => [
            'value' => 'Rino Knowledge Base',
            'type' => 'text',
        ],

        'knowledgebase_seo_description' => [
            'value' => 'Documentation, tutorials, and support articles for Rino services.',
            'type' => 'textarea',
        ],
    ],

    'categories' => [
        'getting-started' => [
            'name' => 'Getting Started',
            'slug' => 'getting-started',
            'description' => 'Everything you need to get started with your service.',
            'active' => true,
            'sort_order' => 10,
        ],

        'server-management' => [
            'name' => 'Server Management',
            'slug' => 'server-management',
            'description' => 'Guides for managing and maintaining your server.',
            'active' => true,
            'sort_order' => 20,
        ],

        'billing' => [
            'name' => 'Billing & Account',
            'slug' => 'billing-account',
            'description' => 'Help with billing, plans, renewals, and your account.',
            'active' => true,
            'sort_order' => 30,
        ],
    ],

    'articles' => [
        'getting-started' => [
            'category' => 'getting-started',
            'title' => 'Getting Started with Your Hosting Service',
            'slug' => 'getting-started-with-your-hosting-service',
            'short_description' => 'Learn the basic steps after ordering your hosting service.',
            'content' =>
                '<p>After ordering your service, open your client area and locate the service you want to manage.</p>'
                . '<p>From there you can access the available management tools, connection information, and service details.</p>',
            'active' => true,
            'sort_order' => 10,
        ],

        'server-access' => [
            'category' => 'server-management',
            'title' => 'How to Access Your Server',
            'slug' => 'how-to-access-your-server',
            'short_description' => 'Find the connection information and management tools for your server.',
            'content' =>
                '<p>Open your service from the client area to view the connection details and available management controls.</p>'
                . '<p>The exact connection method depends on the type of hosting service you purchased.</p>',
            'active' => true,
            'sort_order' => 10,
        ],

        'upgrade-plan' => [
            'category' => 'billing',
            'title' => 'How to Upgrade Your Hosting Plan',
            'slug' => 'how-to-upgrade-your-hosting-plan',
            'short_description' => 'Learn how plan upgrades and additional resources are handled.',
            'content' =>
                '<p>If your current plan no longer provides enough resources, you can move to a larger plan when upgrade options are available.</p>'
                . '<p>Check your client area or contact support for the upgrade options available for your service.</p>',
            'active' => true,
            'sort_order' => 10,
        ],
    ],
];