<?php

return [
    // Website basic information
    'site' => [
        'slogan' => '',
        'keyword' => [],
        // Default image path for asset() helper
        'image' => [
            'url' => '',
            'width' => 0,
            'height' => 0,
        ],
        // hreflang in ISO 3166-1 Alpha 2 or ISO 15924
        // @see https://developers.google.com/search/docs/specialty/international/localized-versions
        'language' => 'zh-tw',
        // For multi-language: ['zh-tw' => '', 'en-us' => '']
        'rss' => 'https://www.tnlmediagene.com/rss',
        'facebook' => [
            // Facebook App ID
            // @see https://developers.facebook.com/
            'application' => '',
            // Facebook fanpage URL
            'fanpage' => '',
        ],
        'x' => [
            // X user ID
            'id' => '',
        ],
    ],

    'separator' => [
        'name' => ' - ',
    ],

    'performance' => [
        // dns-prefetch list, host only
        'prefetch' => [],
        // Browser favicon path for asset() helper
        'icon' => '',
        // Default theme-color
        'color' => '',
    ],

    // Global schema JSON
    'schema' => [
        'Organization' => [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'legalName' => 'TNL Mediagene',
            'slogan' => 'Asia’s Next Generation Digital and Technology Media Group. A comprehensive media and data platform providing news and commentary on current events, business, technology, lifestyle and sports.',
            'url' => 'https://www.tnlmediagene.com/',
            'logo' => 'https://resource.tnlmediagene.com/assets/logo/tnlmediagene.png',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+886-2-66385108',
                'contactType' => 'customer service',
                'areaServed' => 'TW',
                'availableLanguage' => [
                    'English',
                    'Chinese',
                    'Japanese',
                ],
            ],
            'sameAs' => [
                'https://zh.wikipedia.org/zh-tw/TNL_Mediagene',
                'https://www.linkedin.com/company/tnl-mediagene',
                'https://x.com/tnlmediagene',
                'https://www.facebook.com/tnlmediagene',
                'https://www.instagram.com/tnl_mediagene/',
            ],
        ],
        'WebSite' => [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            // Index URL
            'url' => 'https://www.tnlmediagene.com/',
            // Available actions
            // @see https://schema.org/Action
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => 'https://www.tnlmediagene.com/search?q={query}',
                'query' => 'required',
            ],
        ],
    ],
];
