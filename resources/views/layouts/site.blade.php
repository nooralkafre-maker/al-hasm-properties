<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'AL HASM Properties') | AL HASM Properties</title>
  <meta name="description" content="@yield('description', $siteConfig['meta_description_'.app()->getLocale()]??'Explore real estate in Sharjah and Dubai, UAE.')">
  <meta name="theme-color" content="#102c22">
  <link rel="icon" href="{{ asset('assets/img/original-company-logo.png') }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/v3-premium.css') }}">
  @stack('head')
</head>
<body class="v3-main">
  @php($icons=asset('assets/img/icons.svg'))
  <div class="topline premium-topline">
    <div class="container between">
      <span>✦ {{ __('Your trusted real estate partner in the UAE') }}</span>
      <span>⌖ {{ $siteConfig['address']??'Sharjah, UAE' }}</span>
    </div>
  </div>
  <header class="site-nav">
    <div class="container site-nav-inner">
      <a href="{{ route('home') }}" class="brand" aria-label="AL HASM Properties">
        <img src="{{ asset('assets/img/original-company-logo.png') }}" alt="AL HASM company logo">
        <span class="brand-t"><b>AL <em>HASM</em></b><span>PROPERTIES · UAE</span></span>
      </a>
      <nav class="menu" id="public-navigation" aria-label="Main navigation">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home')?'selected':'' }}">{{ __('Home') }}</a>
        <a href="{{ route('properties.index',['kind'=>'sale']) }}">{{ __('Buy') }}</a>
        <a href="{{ route('properties.index',['kind'=>'rent']) }}">{{ __('Rent') }}</a>
        <a href="{{ route('properties.index',['kind'=>'off_plan']) }}">{{ __('New Projects') }}</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about')?'selected':'' }}">{{ __('About Us') }}</a>
        <a href="{{ route('services') }}" class="{{ request()->routeIs('services')?'selected':'' }}">{{ __('Our Services') }}</a>
        <a href="{{ route('blog.index') }}">{{ __('Insights') }}</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact')?'selected':'' }}">{{ __('Contact') }}</a>
      </nav>
      <div class="nav-right">
        <a class="language" href="{{ route('locale.switch',app()->getLocale()==='ar'?'en':'ar') }}">{{ app()->getLocale()==='ar'?'EN':'عربي' }}</a>
        <a class="nav-favorite" href="{{ route('favorites.index') }}" aria-label="Saved properties">♡</a>
        <a class="btn small nav-contact" href="{{ route('contact') }}">{{ __('List a Property') }} ↗</a>
        <button class="icon-btn mobile-menu-btn" type="button" aria-controls="public-navigation" aria-expanded="false" data-v3-nav aria-label="Open navigation">☰</button>
      </div>
    </div>
  </header>
  @if(session('success'))<div class="container"><div class="alert alert-success">{{ session('success') }}</div></div>@endif
  @if($errors->any())<div class="container"><div class="alert alert-error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
  <main>@yield('content')</main>
  <footer class="site-footer">
    <div class="container">
      <div class="footer-top">
        <div class="footer-intro">
          <a href="{{ route('home') }}" class="brand"><img src="{{ asset('assets/img/original-company-logo.png') }}" alt="AL HASM"><span class="brand-t"><b>AL <em>HASM</em></b><span>PROPERTIES · UAE</span></span></a>
          <p>{{ __('Discover extraordinary homes and investment opportunities across the UAE with a partner you can trust.') }}</p>
          <div class="footer-social"><span>✦</span><span>⌂</span><span>✧</span></div>
        </div>
        <div class="footer-col"><h4>{{ __('Discover') }}</h4>
          <a href="{{ route('properties.index',['kind'=>'sale']) }}">{{ __('Properties for Sale') }}</a>
          <a href="{{ route('properties.index',['kind'=>'rent']) }}">{{ __('Properties for Rent') }}</a>
          <a href="{{ route('properties.index',['kind'=>'off_plan']) }}">{{ __('New Projects') }}</a>
          <a href="{{ route('favorites.index') }}">{{ __('Saved') }}</a>
        </div>
        <div class="footer-col"><h4>{{ __('Company') }}</h4>
          <a href="{{ route('about') }}">{{ __('About Us') }}</a>
          <a href="{{ route('services') }}">{{ __('Our Services') }}</a>
          <a href="{{ route('blog.index') }}">{{ __('Insights') }}</a>
          <a href="{{ route('pages.show','privacy') }}">{{ __('Privacy Policy') }}</a>
          <a href="{{ route('pages.show','terms') }}">{{ __('Terms & Conditions') }}</a>
        </div>
        <div class="footer-col"><h4>{{ __('Get in Touch') }}</h4>
          <p>⌖ {{ $siteConfig['address']??'Sharjah, UAE' }}</p>
          @if(!empty($siteConfig['phone']))<p>☎ {{ $siteConfig['phone'] }}</p>@endif
          @if(!empty($siteConfig['email']))<p>✉ {{ $siteConfig['email'] }}</p>@endif
          <a class="footer-contact" href="{{ route('contact') }}">{{ __('Contact Our Team') }} ↗</a>
        </div>
      </div>
      <div class="footer-bottom"><span>© {{ date('Y') }} AL HASM Properties. {{ __('All rights reserved.') }}</span><span>Sharjah · UAE</span></div>
    </div>
  </footer>
  <script src="{{ asset('assets/js/app.js') }}" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded',()=>{const b=document.querySelector('[data-v3-nav]'),n=document.querySelector('#public-navigation');if(b&&n)b.addEventListener('click',()=>{const open=n.classList.toggle('open');b.setAttribute('aria-expanded',String(open));});});
  </script>
  @stack('scripts')
</body>
</html>
