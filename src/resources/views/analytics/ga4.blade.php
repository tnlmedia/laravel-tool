@php
  $list = [];
@endphp
@foreach($config as $slug => $item)
  @if (!($item['id'] ?? false))
    @continue
  @endif
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $item['id'] }}&l={{ $slug }}Ga4Layer"></script>
  <script>
    @php
      $list[] = $slug . "Ga4Layer.push(arguments);";

      echo "window." . $slug . "Ga4Layer = window." . $slug . "Ga4Layer || [];";
      echo PHP_EOL . "function " . $slug . "_gtag () {" . $slug . "Ga4Layer.push(arguments);}";
      echo PHP_EOL . $slug . "_gtag('js', new Date());";
      echo PHP_EOL . $slug . "_gtag('config', '" . $item['id'] . "');";
      foreach ($item['event'] ?? [] as $type => $event) {
          switch ($type) {
              case 'author':
                  foreach ($material['authors'] ?? [] as $author) {
                      if (!($author['name'] ?? false)) {
                          continue;
                      }
                      echo PHP_EOL . $slug . "_gtag('event', '" . $event . "', {action: 'trigger', label: '" . $author['name'] . "'});";
                  }
                  break;

              case 'term':
                  foreach ($material['terms'] ?? [] as $term) {
                      if (!($term['name'] ?? false)) {
                          continue;
                      }
                      echo PHP_EOL . $slug . "_gtag('event', '" . $event . "', {action: 'trigger', label: '" . $term['name'] . "'});";
                  }
                  break;
          }
      }
    @endphp
  </script>
@endforeach
@if ($list)
  <script>
    function gtag_all () {
      @php
        echo implode(PHP_EOL, $list);
      @endphp
    }
  </script>
@endif
