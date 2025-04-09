<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="HandheldFriendly" content="true">
<meta name="MobileOptimized" content="width">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">



{{-- DNS Prefetch --}}
<link rel="dns-prefetch" href="//www.cool3c.com">
<link rel="dns-prefetch" href="//account.cool3c.com">
<link rel="dns-prefetch" href="//contentparty.org">
<link rel="dns-prefetch" href="//www.w3.org">
<link rel="dns-prefetch" href="//ogp.me">
<link rel="dns-prefetch" href="//smarturl.it">
<link rel="dns-prefetch" href="//www.google-analytics.com">
<link rel="dns-prefetch" href="//www.googletagmanager.com">
<link rel="dns-prefetch" href="//plus.google.com">
<link rel="dns-prefetch" href="//www.facebook.com">
{{-- Information --}}
@if (!empty($global['meta']['url']))
  <link rel="canonical" href="{!! $global['meta']['url'] !!}">
@endif
{{--            @if (!empty($global['meta']['amp']))--}}
{{--                <link rel="amphtml" href="{!! $global['meta']['amp'] !!}">--}}
{{--            @endif--}}
<link rel="alternate" hreflang="zh-Hant" href="{!! $global['meta']['url'] !!}">
<link rel="alternate" type="application/rss+xml" title="{{ config('app.name') }}" hreflang="zh-Hant" href="https://feeds.feedburner.com/cool3c-show">
<meta name="copyright" content="Cool3c Media Ltd.">
@foreach ($global['meta']['author'] as $item)
  <meta name="author" content="{{ $item }}">
@endforeach
<meta name="description" content="{{ $global['meta']['description']['basic'] . $global['meta']['description']['extra'] }}">
<meta name="keywords" content="{{ implode(',', $global['meta']['keyword']) }}">
<meta name="robots" content="{{ $global['meta']['robots'] }}">
@forelse ($global['meta']['google']['author'] as $item)
  <link rel="author" href="{!! $item !!}">
@empty
  <link rel="author" href="https://plus.google.com/+cool3ctw/posts">
@endforelse
<link rel="publisher" href="https://plus.google.com/+Cool3c">
@if (in_array($global['page']['key'][0], ['article', 'preview']) && !empty($global['page']['key'][1]))
  <meta name="news_keywords" content="{{ implode(',', $global['meta']['keyword']) }}">
  <meta name="Googlebot-News" content="all">
@endif
<meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}">
<meta property="fb:pages" content="{{ config('services.facebook.page_id') }}">
<meta property="og:type" content="{{ $global['meta']['og']['type'] }}">
<meta property="og:url" content="{{ $global['meta']['url'] }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="{{ !empty($global['title']['basic']) ? $global['title']['basic'] . ' - ': '' }}{{ config('app.name') }}">
<meta property="og:description" content="{{ $global['meta']['description']['basic'] }}">
<meta property="og:image" content="{{ $global['meta']['image'] }}">
@if ($global['meta']['og']['type'] == 'article')
  @foreach ($global['meta']['og']['see_also'] as $item)
    <meta property="og:see_also" content="{{ $item }}">
  @endforeach
  @foreach ($global['meta']['keyword'] as $item)
    <meta property="article:tag" content="{{ $item }}">
  @endforeach
  <meta property="article:publisher" content="https://www.facebook.com/cool3c.tw">
  <meta property="article:section" content="{{ $global['meta']['og']['section'] }}">
  @forelse ($global['meta']['og']['author'] as $item)
    <meta property="article:author" content="{{ $item }}">
  @empty
    <meta property="article:author" content="https://www.facebook.com/cool3c.tw">
  @endforelse
  <meta property="article:modified_time" content="{{ $global['meta']['og']['modified'] }}">
  <meta property="article:published_time" content="{{ $global['meta']['og']['published'] }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@cool3c">
<meta name="twitter:title" content="{{ !empty($global['title']['basic']) ? $global['title']['basic'] . ' - ': '' }}{{ config('app.name') }}">
<meta name="twitter:description" content="{{ $global['meta']['description']['basic'] }}">
<meta name="twitter:creator" content="@cool3c">
<meta name="twitter:image" content="{{ $global['meta']['image'] }}">
@if ($global['meta']['page_id'])
  <meta property="dable:item_id" content="{{ $global['meta']['page_id'] }}">
@endif
<link rel="shortcut icon" href="{!! url('favicon.ico') !!}" type="image/x-icon">
<link rel="icon" href="{!! url('favicon.ico') !!}" type="image/x-icon">
{{-- Style --}}
<meta name="theme-color" content="#2c2c2c">
@stack('styles')
{{-- Javascript --}}
<script type="application/json" id="settings-page">@json($global['page'])</script>
<script type="application/json" id="settings-material">@json($global['material'])</script>
<script type="application/json" id="settings-analytics">@json($global['analytics'])</script>
{{-- Flux --}}
@include('layouts.partials.flux')
{{-- Analytics --}}
@include('components.analytics')
<script>
  {!! Vite::content('resources/js/header.js', 'assets') !!}
</script>
{{-- Style asynchronous --}}
<link rel="stylesheet" href="{{ Vite::asset('resources/css/style.scss', 'assets') }}" media="all">
{{-- tnlmedia web component js --}}
<script src="https://resource.tnlmediagene.com/assets/v1/js/tnlmedia-header-footer.js" defer></script>
{{-- Schema.org --}}
@foreach ($global['schema'] as $item)
  <script type="application/ld+json">@json($item)</script>
@endforeach
{{-- Adsense --}}
<script data-ad-client="ca-pub-4618526234247744" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
{{-- OneSignal --}}
@if ($_SERVER['HTTP_HOST'] == 'www.cool3c.com')
  <link rel="manifest" href="{!! url('manifest.json') !!}">
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
@endif
{{-- Lndata Code --}}
<noscript>
  <img src="https://v.lndata.com/i/a76365,b1348475,c3508,i0,m202,8a1,8b2,h" width="1" height="1">
</noscript>
@stack('head')
