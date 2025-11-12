# Analytics (Frontend)

The Blade frontend helpers provide basic analytics features. You can extend or customize event tracking as needed.

## Track class

Set the `tmg-analytics.track` class to any element to enable click and impression tracking. Example:

```html
<a href="#" class="track-click track-impression" data-track-event="Sign" data-track-label="Up">Sign Up</a>
```

## Google Analytics 4 (GA4)

TMGBlade will automatically send events for `Counter-Author`, `Counter-Term`, and `Paid-Content` from material metadata.

To send custom events, use the gtag function wrappers. Example:

```javascript
core_gtag('event', 'Sign', {action: 'click', label: 'Up'});
```

You can target specific GA4 instances by using key as different prefixes:

```javascript
// Send event to a specific GA4 instance
core_gtag('event', 'Sign', {action: 'click', label: 'Up'});
second_gtag('event', 'Sign', {action: 'click', label: 'Up'});

// Send event to all GA4 instances
gtag_all('event', 'Sign', {action: 'click', label: 'Up'});
```

## Google Tag Manager (GTM)

TMGBlade will automatically push dataLayer objects for `analyticsAuthors`, `analyticsTerms`, and `paidContent` from material metadata.

You can target specific GTM container by using key as different prefixes:

```javascript
// Send data to a specific GTM container
coreGtmLayer.push({event: 'Sign', action: 'click', label: 'Up'});
secondGtmLayer.push({event: 'Sign', action: 'click', label: 'Up'});

// Send data to all GTM containers
gtmLayerAll.push({event: 'Sign', action: 'click', label: 'Up'});
```

## Comscore

There are no helper functions for Comscore.

## Facebook Pixel

To send events to Facebook Pixel, use the standard fbq API:

```javascript
fbq('track', 'SignUp', {action: 'click', label: 'Up'});
```

## Chartbeat

There are no helper functions for Chartbeat.
