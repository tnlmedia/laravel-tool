# Analytics for frontend

Blade only provide basic analytics features, but you can custom more event tracking by yourself.

## Track class

You can set `tmg-analytics.track` class to any element for track click and impression event.

```html
<a href="#" class="track-click track-impression" data-track-event="Sign" data-track-label="Up">Sign Up</a>
```

## Google analytics 4

Blade will automatically send event for `Counter-Author`, `Counter-Term` and `Paid-Content` from material metadata.

You can send more event via follow functions:

```javascript
core_gtag('event', 'Sign', {action: 'click', label: 'Up'});
```

The key will be the functions prefix:

```javascript
// Send event to specific ga4
core_gtag('event', 'Sign', {action: 'click', label: 'Up'});
second_gtag('event', 'Sign', {action: 'click', label: 'Up'});

// Send event to all ga4
gtag_all('event', 'Sign', {action: 'click', label: 'Up'});
```

## Google tag manager

Blade will automatically send datalayer for `analyticsAuthors`, `analyticsTerms` and `paidContent` from material metadata.

You can send more datalayer via follow datalayer:

```javascript
coreGtmLayer.push({event: 'Sign', action: 'click', label: 'Up'});
```

The key will be the datalayer prefix:

```javascript
// Send datalayer to specific gtm
coreGtmLayer.push({event: 'Sign', action: 'click', label: 'Up'});
secondGtmLayer.push({event: 'Sign', action: 'click', label: 'Up'});

// Send datalayer to all gtm
gtmLayerAll.push({event: 'Sign', action: 'click', label: 'Up'});
```

## Comscore

There is no help function for comscore.

## Facebook pixel

You can send event as general facebook pixel function:

```javascript
fbq('track', 'SignUp', {action: 'click', label: 'Up'});
```

## Chartbeat

There is no help function for chartbeat.
