# Advertising (Frontend)

The advertising utilities provide useful features for frontend developers.

## Render advertisements

Advertisements need to be rendered manually. Call the following function to scan and render ad slots on the page:

```javascript
tmgad.scan();
```

## Custom event listener

To listen for advertisement events, configure a custom handler using the configuration key `tmg-advertising.gam.event`.

For more details about available events and payloads, see Google Publisher Tag event listeners:

https://developers.google.com/publisher-tag/samples/ad-event-listeners
