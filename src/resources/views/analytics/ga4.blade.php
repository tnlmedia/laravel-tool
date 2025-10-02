@php
  $list = [];
@endphp
@foreach($config as $slug => $item)
  @if (!($item['id'] ?? false))
    @continue
  @endif
  @if (!($config['gateway'] ?? false))
    <script async src="{{ $config['gateway'] }}?id={{ $item['id'] }}&l={{ $slug }}Ga4Layer"></script>
  @else
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $item['id'] }}&l={{ $slug }}Ga4Layer"></script>
  @endif
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
                      echo PHP_EOL . $slug . "_gtag('event', '" . $event . "', {action: 'trigger', label: '" . $author['name'] . "', slug: '" . $author['key'] . "'});";
                  }
                  break;

              case 'term':
                  foreach ($material['terms'] ?? [] as $term) {
                      if (!($term['name'] ?? false)) {
                          continue;
                      }
                      echo PHP_EOL . $slug . "_gtag('event', '" . $event . "', {action: 'trigger', label: '" . $term['name'] . "', slug: '" . $term['key'] . "'});";
                  }
                  break;

              case 'paid':
                  if ($material['paid'] ?? false) {
                      $name = match ($material['paid']) {
                          0 => 'Free',
                          1 => 'Paid',
                          2 => 'User',
                          default => 'Unknown',
                      };
                      echo PHP_EOL . $slug . "_gtag('event', '" . $event . "', {action: 'trigger', label: '" . $name . "', slug: '" . $material['paid'] . "'});";
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
