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
            'legalName' => '關鍵評論網股份有限公司',
            'alternateName' => 'The News Lens Co., Ltd.',
            'url' => 'https://www.tnlmediagene.com/about',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => '信義區',
                'addressRegion' => '臺北市',
                'postalCode' => '110',
                'streetAddress' => '菸廠路88號4樓',
                'addressCountry' => [
                    '@type' => 'Country',
                    'name' => 'TW',
                ],
            ],
            'foundingDate' => '2013-05-21',
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => 'TNL Mediagene',
                'url' => 'https://www.tnlmediagene.com/',
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
