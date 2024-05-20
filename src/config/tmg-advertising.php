<?php

return [
    'gam' => [
        // Join GAM code or not, force via flux
        'status' => false,
        // GAM event listener, format [event name, callback function]
        // @see https://developers.google.com/publisher-tag/samples/ad-event-listeners
        'event' => [
            ['SlotRenderEnded', 'SlotOnloadCallback'],
        ],
    ],

    'flux' => [
        // Join flux code or not
        'status' => false,
        // Flux core js
        'core' => '',
        // Failed timeout (int): Optional, default 3000ms
        'timeout' => 3000,
    ],

    'slot' => [
        // Ad slot sample config
        'sample' => [
            // Slot type (string): Optional
            // general: Default, general GAM slot
            // oop: GAM out-of-page slot
            // flux: Flux prebid slot
            'type' => 'general',
            // Slot name (string): Required, format: /{GAM network ID}/{slot name}
            'slot' => '/000/sample-slot',
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
