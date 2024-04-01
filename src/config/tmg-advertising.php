<?php

return [
    'flux' => [
        // Flux core js
        'core' => '',
        // Failed timeout (int): Optional, default 3000ms
        'timeout' => 3000,
    ],

    'gam' => [
        // GAM event listener, format [event name, callback function]
        // @see https://developers.google.com/publisher-tag/samples/ad-event-listeners?hl=zh-tw
        'event' => [
            ['SlotRenderEnded', 'SlotOnloadCallback'],
        ],
    ],

    'slot' => [
        // Ad slot sample config
        // Slot name (string): Required, format: /{GAM network ID}/{slot name}
        '/000/sample-slot' => [
            // Slot type (string): Optional
            // general: Default, general GAM slot
            // oop: GAM out-of-page slot
            // flux: Flux prebid slot
            'type' => 'general',
            // Default size (array): Optional, default use last mapping size
            'size' => [
                [300, 250],
                [640, 480],
            ],
            // Size mapping (array): Optional, format: [viewport, [slot size list]]
            'mapping' => [
                [[640, 0], [[300, 250], [640, 480]]],
                [[0, 0], [[300, 250]]],
            ],
            // Key-value targeting (array): Optional, format: [key => [value]]
            // Property: renderSlot() > setTargeting() > config
            'targeting' => [
                'category' => ['news'],
                'author' => ['author1', 'author2'],
            ],
        ],
    ],
];
