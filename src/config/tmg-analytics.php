<?php
return [
    // Track event
    'track' => [
        // Event data attribute prefix
        // Event name: data-track-event
        // Event label: data-track-label
        'prefix' => 'data-track',
        // Class to track element click
        // GA4: gtag('event', event, {action: 'click', label: label});
        // GTM: gtmDataLayer.push({event: event, eventType: 'click', eventValue: label});
        'click' => 'track-click',
        // Class to track element view
        // GA4: gtag('event', event, {action: 'impression', label: label});
        // GTM: gtmDataLayer.push({event: event, eventType: 'impression', eventValue: label});
        'impression' => 'track-impression',
    ],
    // Google Analytics 4
    'ga4' => [
        // Trigger event: slug_gtag('event', event, {});
        'core' => [
            // Measurement ID: G-XXXXXXX
            'id' => '',
            // Global event when loaded: [type => event_name]
            'event' => [
                // Author list
                'author' => 'Counter-Author',
                // Term list
                'term' => 'Counter-Term',
            ],
        ],
    ],
    // Google Tag Manager
    'gtm' => [
        // Put datalayer: slugGtmLayer.push({});
        'core' => [
            // ID: GTM-XXXXXXX
            'id' => '',
            // Basic data layer when loaded
            // {materialAuthors}: Author list from material
            // {materialTerms}: Term list from material
            'layer' => [
                'analyticsAuthors' => '{materialAuthors}',
                'analyticsTerms' => '{materialTerms}',
            ],
        ],
    ],
    // Comscore
    'comscore' => [
        // Tag type
        'c1' => '',
        // Client ID
        'c2' => '',
        // enableFirstPartyCookie
        'first_party' => true,
        // bypassUserConsentRequirementFor1PCookie
        'bypass_user' => true,
    ],
    // Facebook pixel
    'facebook' => [
        // Pixel ID
        'id' => '',
        // Enable automatic content tracking
        'path_content' => [
            'article/*',
        ],
    ],
    // Chartbeat
    'chartbeat' => [
        // Account ID
        'account' => '',
    ],
];
