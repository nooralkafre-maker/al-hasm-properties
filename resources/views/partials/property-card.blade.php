<article class="property-card">
  <div class="property-cover">
    <a href="{{ route('properties.show',$property) }}">
      <img src="{{ $property->image_url }}" data-image-fallback="{{ asset('assets/img/property-default.svg') }}" alt="{{ $property->title }}" loading="lazy">
    </a>
    <span class="chip {{ $property->kind }}">{{ $property->kind==='sale'?__('For Sale'):($property->kind==='rent'?__('For Rent'):__('Off-Plan')) }}</span>
    <form method="post" action="{{ route('favorites.toggle',$property) }}" class="favorite-form">
      @csrf
      <button class="heart {{ in_array($property->id,session('favorite_ids',[]))?'saved':'' }}" type="submit" aria-label="{{ __('Save Property') }}">♡</button>
    </form>
  </div>
  <div class="property-info">
    <div class="price">AED {{ number_format((float)$property->price) }}@if($property->kind==='rent') <span class="tiny muted">/{{ $property->price_period==='monthly'?__('month'):__('year') }}</span>@endif</div>
    <h3><a href="{{ route('properties.show',$property) }}">{{ $property->title }}</a></h3>
    <p>⌖ {{ $property->area }}, {{ $property->city }}</p>
    <div class="facts">
      <span>▤ {{ $property->bedrooms }} {{ __('Beds') }}</span>
      <span>▱ {{ $property->bathrooms }} {{ __('Baths') }}</span>
      <span>▣ {{ number_format($property->area_sqft) }} {{ __('sq.ft') }}</span>
    </div>
    <a class="btn secondary small wide mt24" href="{{ route('properties.show',$property) }}">{{ __('View details') }} ↗</a>
  </div>
</article>
