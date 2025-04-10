@php
  $class = [];
  $class[] = 'tmgad';
  $class[] = 'tmgad-type-' . ($config['type'] ?? 'general');
  $class[] = 'tmgad-new';
  $class = array_unique(array_merge($class, $config['class'] ?? []));
@endphp
<div class="{{ implode(' ', $class) }}" style="{{ $config['style'] ?? '' }}">
  <script type="application/json">@json($config ?? [])</script>
</div>
