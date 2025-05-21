@if (($config['c1'] ?? false) && ($config['c2'] ?? false))
  <script>
    var _comscore = _comscore || [];
    _comscore.push({
      c1: '{{ $config['c1'] }}',
      c2: '{{ $config['c2'] }}',
      options: {
        enableFirstPartyCookie: {{ ($config['first_party'] ?? true) ? 'true' : 'false' }},
        bypassUserConsentRequirementFor1PCookie: {{ ($config['bypass_user'] ?? true) ? 'true' : 'false' }},
      },
    });
  </script>
  <script async src="https://sb.scorecardresearch.com/cs/{{ $config['c2'] }}/beacon.js"></script>
@endif
