@if ($config['id'] ?? false)
  <script async src="https://connect.facebook.net/en_US/fbevents.js"></script>
  <script>
    !function (f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
    }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $config['id'] }}');
    fbq('track', 'PageView');
    @foreach ($config['path_content'] ?? [] as $path)
    @if (request()->is($path))
    fbq('track', 'ViewContent');
    @break
    @endif
    @endforeach
  </script>
@endif
