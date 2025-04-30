@if ($config['account'] ?? false)
  <script async src="//static.chartbeat.com/js/chartbeat_mab.js"></script>
  <script>
    (function () {
      var _sf_async_config = window._sf_async_config = (window._sf_async_config || {});
      _sf_async_config.uid = {{ $config['account'] }};
      _sf_async_config.domain = '{{ $host }}';
      _sf_async_config.flickerControl = false;
      _sf_async_config.useCanonical = true;
      _sf_async_config.useCanonicalDomain = true;
      _sf_async_config.sections = '{{ implode(',', array_column(array_filter($material['terms'], fn ($item): bool => $item['type'] == 'category'), 'name')) }}';
      _sf_async_config.authors = '{{ implode(',', array_column($material['authors'], 'name')) }}';
    })();
  </script>
  <script async src="//static.chartbeat.com/js/chartbeat.js"></script>
@endif
