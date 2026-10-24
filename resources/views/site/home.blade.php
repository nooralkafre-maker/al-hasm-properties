@extends('layouts.site')
@section('title', __('Luxury Homes, Exceptional Living'))
@section('description', 'Discover distinctive properties for sale and rent in Sharjah, Dubai and across the UAE.')
@section('content')
@php($ar = app()->getLocale()==='ar')
<section class="hero premium-hero">
  <div class="hero-veil"></div>
  <div class="container hero-inner">
    <div class="hero-copy">
      <div class="hero-kicker"><span class="hero-kicker-line"></span>{{ $ar?'فن العيش بأسلوب استثنائي':'THE ART OF EXTRAORDINARY LIVING' }}</div>
      <h1>{{ $ar?'حيث لكل عنوان':'Where every address' }}<br><em>{{ $ar?'حكاية تستحق العيش.':'tells a story.' }}</em></h1>
      <p>{{ $ar?'اكتشف مجموعة مختارة من المنازل والفرص الاستثمارية الراقية في الشارقة ودبي ومختلف الإمارات.':'Discover an elevated collection of homes and investment opportunities across Sharjah, Dubai and the Emirates.' }}</p>
      <div class="hero-ctas">
        <a href="{{ route('properties.index') }}" class="btn hero-primary">{{ $ar?'اكتشف عقاراتنا':'Explore our collection' }} ↗</a>
        <a href="{{ route('about') }}" class="hero-text-link">{{ $ar?'ما يميز الحسم':'The AL HASM difference' }} ↗</a>
      </div>
      <div class="hero-caption">✧ {{ $ar?'منازل تعشقها واستثمارات تثق بها.':'Homes to love. Investments to believe in.' }}</div>
    </div>
    <div class="hero-signature"><span class="signature-number">01 <small>/ 03</small></span><div><small>{{ $ar?'المجموعة المميزة':'THE SIGNATURE COLLECTION' }}</small><strong>{{ $ar?'أماكن استثنائية وجمال يدوم.':'Extraordinary spaces, timeless appeal.' }}</strong></div><span class="signature-arrow">↗</span></div>
  </div>
</section>
<div class="container hero-search-holder">
  <div class="search-lead"><span class="small-square">✧</span>{{ $ar?'دعنا نساعدك في العثور على منزلك':'LET US FIND YOUR PLACE' }}</div>
  <form class="search-box" action="{{ route('properties.index') }}" method="get">
    <div class="tabset">
      <label class="tab active"><input hidden type="radio" name="kind" value="sale" checked>{{ __('Buy') }}</label>
      <label class="tab"><input hidden type="radio" name="kind" value="rent">{{ __('Rent') }}</label>
      <label class="tab"><input hidden type="radio" name="kind" value="off_plan">{{ __('Off-Plan') }}</label>
    </div>
    <div class="search-grid">
      <div class="field"><label for="hero-city">{{ __('Location') }}</label><select id="hero-city" name="city"><option value="">{{ __('All Emirates') }}</option><option>Sharjah</option><option>Dubai</option><option>Abu Dhabi</option><option>Ajman</option></select></div>
      <div class="field"><label for="hero-type">{{ __('Property Type') }}</label><select id="hero-type" name="type"><option value="">{{ __('All Types') }}</option>@foreach(['apartment','villa','townhouse','penthouse','commercial','land'] as $type)<option value="{{ $type }}">{{ __(ucfirst($type)) }}</option>@endforeach</select></div>
      <div class="field"><label for="hero-price">{{ __('Maximum Price (AED)') }}</label><select id="hero-price" name="max"><option value="">{{ __('Any Price') }}</option>@foreach([500000,1000000,2000000,5000000,10000000] as $price)<option value="{{ $price }}">{{ number_format($price) }}</option>@endforeach</select></div>
      <div class="field"><label for="hero-beds">{{ __('Bedrooms') }}</label><select id="hero-beds" name="beds"><option value="">{{ __('Any') }}</option>@foreach([1,2,3,4,5] as $n)<option value="{{ $n }}">{{ $n }}+</option>@endforeach</select></div>
      <button type="submit" class="btn">⌕ {{ __('Search Properties') }}</button>
    </div>
  </form>
</div>
<section class="trust-section"><div class="container trust-row">
  <div><span class="trust-symbol">⌂</span><strong>{{ $ar?'عقارات مختارة بعناية':'Thoughtfully selected' }}</strong><small>{{ $ar?'الجودة قبل الكمية':'Quality over quantity' }}</small></div>
  <div><span class="trust-symbol">✧</span><strong>{{ $ar?'خبرة بالسوق المحلي':'Local knowledge' }}</strong><small>{{ $ar?'الشارقة ودبي والمزيد':'Sharjah, Dubai & beyond' }}</small></div>
  <div><span class="trust-symbol">◇</span><strong>{{ $ar?'إرشاد واضح':'Clear guidance' }}</strong><small>{{ $ar?'قرارات مدروسة':'Confident decisions' }}</small></div>
  <div><span class="trust-symbol">♧</span><strong>{{ $ar?'خدمة شخصية':'Personal support' }}</strong><small>{{ $ar?'معك في كل خطوة':'Always by your side' }}</small></div>
</div></section>
<section class="section featured-section"><div class="container">
  <div class="heading premium-heading"><div><span class="editorial-label">01 / {{ $ar?'مجموعتنا':'OUR COLLECTION' }}</span><h2>{{ $ar?'عقارات تليق':'Curated for the way' }}<br><em>{{ $ar?'بطريقة حياتك.':'you want to live.' }}</em></h2><p>{{ $ar?'تعرّف إلى مساكن راقية وفرص استثمارية ملهمة في أنحاء الإمارات.':'Explore refined residences and inspiring opportunities across the UAE.' }}</p></div><a href="{{ route('properties.index') }}" class="elegant-link">{{ $ar?'عرض جميع العقارات':'View all properties' }} ↗</a></div>
  <div class="property-picks"><a class="active" href="{{ route('properties.index') }}">{{ __('Featured') }}</a><a href="{{ route('properties.index',['kind'=>'sale']) }}">{{ __('For Sale') }}</a><a href="{{ route('properties.index',['kind'=>'rent']) }}">{{ __('For Rent') }}</a><a href="{{ route('properties.index',['kind'=>'off_plan']) }}">{{ __('Off-Plan') }}</a></div>
  @php($displayFeatured = $featured->count() ? $featured : $newest)
  <div class="property-grid">@forelse($displayFeatured as $property) @include('partials.property-card') @empty<div class="empty">{{ __('No properties available yet.') }}</div>@endforelse</div>
  <div class="center-action"><a href="{{ route('properties.index') }}" class="btn secondary">{{ $ar?'اكتشف جميع العقارات':'Discover all properties' }} ↗</a></div>
</div></section>
<section class="editorial-split">
  <div class="editorial-photo"><img src="{{ asset('assets/img/villa-b.jpg') }}" alt="Contemporary luxury residence" loading="lazy"><span class="photo-mark">AL HASM <i>COLLECTION</i></span></div>
  <div class="editorial-copy"><span class="editorial-label light">02 / {{ $ar?'تجربة الحسم':'THE AL HASM EXPERIENCE' }}</span><h2>{{ $ar?'نؤمن بأن المنزل':'We believe a home' }}<br><em>{{ $ar?'أكثر من مجرد مكان.':'is more than a place.' }}</em></h2><p>{{ $ar?'العثور على العقار المناسب يبدأ بفهم طموحاتك وأسلوب حياتك وخطوتك القادمة. نقدم تجربة شخصية مدروسة في كل عملية بحث.':'Finding the right property is about understanding your ambitions, your lifestyle and your next chapter. We bring a considered, personal approach to every search.' }}</p><div class="editorial-check"><span>✓</span>{{ $ar?'دعم شخصي من البحث حتى اتخاذ القرار':'Dedicated guidance from search to decision' }}</div><div class="editorial-check"><span>✓</span>{{ $ar?'فرص تتناسب مع أسلوب حياتك':'Opportunities to match your lifestyle' }}</div><div class="editorial-check"><span>✓</span>{{ $ar?'تواصل واضح ونصائح شفافة':'Clear communication and honest advice' }}</div><a href="{{ route('about') }}" class="btn editorial-button">{{ $ar?'اكتشف قصتنا':'Discover our story' }} ↗</a></div>
</section>
<section class="section communities-section"><div class="container">
  <div class="heading premium-heading"><div><span class="editorial-label">03 / {{ $ar?'اكتشف المناطق':'EXPLORE NEIGHBOURHOODS' }}</span><h2>{{ $ar?'أين تبدأ':'Where would you' }}<br><em>{{ $ar?'حكايتك القادمة؟':'like to belong?' }}</em></h2><p>{{ $ar?'من المساكن المطلة على البحر إلى المجتمعات العائلية النابضة بالحياة.':'From waterfront living to vibrant family communities.' }}</p></div></div>
  <div class="communities">@foreach([['Al Zahia','Sharjah','villa-a.jpg'],['Dubai Marina','Dubai','apartment.jpg'],['Palm Jumeirah','Dubai','villa-b.jpg'],['Al Majaz','Sharjah','skyline-clean.jpg']] as $i=>$area)
    <a class="community" href="{{ route('properties.index',['city'=>$area[1]]) }}"><img src="{{ asset('assets/img/'.$area[2]) }}" alt="{{ $area[0] }}" loading="lazy"><span class="community-gradient"></span><span class="community-index">0{{ $i+1 }}</span><span class="community-content">{{ $area[0] }}<small>{{ $area[1] }} · {{ __('Explore Properties') }} ↗</small></span></a>
  @endforeach</div>
</div></section>
<section class="service-section"><div class="container">
  <div class="heading premium-heading"><div><span class="editorial-label">04 / {{ $ar?'خدماتنا':'WHAT WE DO' }}</span><h2>{{ $ar?'خطوتك القادمة،':'Your next move,' }}<br><em>{{ $ar?'بين أيدٍ خبيرة.':'expertly guided.' }}</em></h2></div><a href="{{ route('services') }}" class="elegant-link">{{ $ar?'جميع الخدمات':'All services' }} ↗</a></div>
  <div class="service-grid"><a class="service-card" href="{{ route('properties.index',['kind'=>'sale']) }}"><span>01 <b>↗</b></span><div class="service-icon">⌂</div><h3>{{ $ar?'شراء عقار':'Buy a property' }}</h3><p>{{ $ar?'اعثر على منزل يعكس طموحاتك بعناية في كل خطوة.':'Find a home that reflects your vision, with care at every step.' }}</p></a><a class="service-card" href="{{ route('properties.index',['kind'=>'rent']) }}"><span>02 <b>↗</b></span><div class="service-icon">⚿</div><h3>{{ $ar?'استئجار منزل':'Rent a home' }}</h3><p>{{ $ar?'اكتشف أماكن ملهمة وخيارات سكن تناسب احتياجاتك.':'Discover inspiring places and flexible living possibilities.' }}</p></a><a class="service-card" href="{{ route('contact') }}"><span>03 <b>↗</b></span><div class="service-icon">◇</div><h3>{{ $ar?'الاستشارات العقارية':'Property advisory' }}</h3><p>{{ $ar?'اتخذ قرارات واثقة بمشورة عقارية شخصية ومدروسة.':'Make confident decisions with thoughtful, personal guidance.' }}</p></a></div>
</div></section>
<section class="closing-cta"><div class="container"><span class="editorial-label light">{{ $ar?'لنجد ما يناسب طموحك':'LET’S FIND WHAT MOVES YOU' }}</span><h2>{{ $ar?'فصلك القادم':'Your next chapter' }}<br><em>{{ $ar?'يبدأ من هنا.':'starts here.' }}</em></h2><p>{{ $ar?'هل أنت جاهز لاستكشاف عنوان جديد؟ يسعدنا أن نسمع قصتك.':'Ready to explore a new address? We would love to hear your story.' }}</p><a class="btn hero-primary" href="{{ route('contact') }}">{{ $ar?'تواصل مع فريقنا':'Speak with our team' }} ↗</a></div></section>
@endsection
@push('scripts')<script>
 document.querySelectorAll('.search-box .tab').forEach(tab=>tab.addEventListener('click',()=>{document.querySelectorAll('.search-box .tab').forEach(x=>x.classList.remove('active'));tab.classList.add('active');tab.querySelector('input').checked=true;}));
</script>@endpush
