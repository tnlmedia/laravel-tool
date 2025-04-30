@php
  $list = [];
@endphp
@foreach($config as $slug => $item)
  @if (!($item['id'] ?? false))
    @continue
  @endif
  <script>
    @php
      $list[] = $slug . "GtmLayer.push(arguments);";
      echo "window." . $slug . "GtmLayer = window." . $slug . "GtmLayer || [];";
      echo PHP_EOL . $slug . "GtmLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});";
      if ($item['layer'] ?? false) {
        foreach ($item['layer'] as $key => $value) {
            $item['layer'][$key] = match ($value) {
                '{materialAuthors}' => $material['authors'] ?? [],
                '{materialTerms}' => $material['terms'] ?? [],
                default => $value,
            };
        }
        echo PHP_EOL . $slug . "GtmLayer.push(JSON.parse('" . json_encode($item['layer'], JSON_UNESCAPED_UNICODE) . "'));";
      }
    @endphp
  </script>
  <script async src="https://www.googletagmanager.com/gtm.js?id={{ $item['id'] }}&l={{ $slug }}GtmLayer"></script>
@endforeach
@if ($list)
  <script>
    window.gtmLayerAll = window.gtmLayerAll || [];
    gtmLayerAll.push = function () {
      @php
        echo implode(PHP_EOL, $list);
      @endphp
        return Array.prototype.push.apply(this, arguments);
    };
  </script>
@endif
