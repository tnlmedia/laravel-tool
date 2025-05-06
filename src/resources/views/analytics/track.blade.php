@if (($config['click'] ?? false) || ($config['impression'] ?? false))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      @if ($config['click'] ?? false)
      document.querySelectorAll('.{{ $config['click'] }}').forEach((item) => {
        item.addEventListener('click', (pointer) => {
          let event = String(item.getAttribute('{{ $config['prefix'] ?? 'data-track' }}-event'));
          let label = String(item.getAttribute('{{ $config['prefix'] ?? 'data-track' }}-label'));
          try {
            gtag_all('event', event, {action: 'click', label: label});
          } catch (e) { }
          try {
            gtmLayerAll.push({event: event, eventType: 'click', eventValue: label});
          } catch (e) { }
        });
      });
      @endif
      @if ($config['impression'] ?? false)
      let observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            let event = String(entry.target.getAttribute('{{ $config['prefix'] ?? 'data-track' }}-event'));
            let label = String(entry.target.getAttribute('{{ $config['prefix'] ?? 'data-track' }}-label'));
            try {
              gtag_all('event', event, {action: 'impression', label: label});
            } catch (e) { }
            try {
              gtmLayerAll.push({event: event, eventType: 'impression', eventValue: label});
            } catch (e) { }
            observer.unobserve(entry.target);
          }
        });
      }, {
        root: null,
        threshold: .7,
      });
      document.querySelectorAll('.{{ $config['impression'] }}').forEach((item) => {
        observer.observe(item);
      });
      @endif
    });
  </script>
@endif
