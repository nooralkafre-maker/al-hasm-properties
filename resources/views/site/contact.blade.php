@extends('layouts.site')
@section('title',__('Contact Us'))
@section('content')
@php($ar=app()->getLocale()==='ar')
<section class="inner-hero contact-hero"><div class="container inner-hero-content"><span class="editorial-label light">{{ $ar?'يسعدنا تواصلك معنا':'WE’D LOVE TO HEAR FROM YOU' }}</span><h1>{{ $ar?'لنبدأ':'Let’s start' }}<br><em>{{ $ar?'المحادثة.':'a conversation.' }}</em></h1><p>{{ $ar?'سواء كنت تبحث عن شراء أو استئجار عقار أو استكشاف الخيارات، فريقنا جاهز لمساعدتك.':'Buying, renting or simply exploring your options? Our team is here to listen.' }}</p></div></section>
<section class="section contact-content"><div class="container contact-layout">
  <div class="contact-story"><span class="editorial-label">{{ $ar?'تواصل معنا':'GET IN TOUCH' }}</span><h2>{{ $ar?'محادثات حقيقية.':'Real conversations.' }}<br><em>{{ $ar?'قرارات أفضل.':'Better decisions.' }}</em></h2><p>{{ $ar?'أخبرنا بما يهمك وسنساعدك في استكشاف أفضل الخيارات المتاحة.':'Tell us what matters to you and we will help you explore the possibilities.' }}</p>
    <div class="contact-method"><span>⌖</span><div><b>{{ __('Visit Our Office') }}</b><p>{{ $siteConfig['address']??'Sharjah, UAE' }}</p></div></div>
    @if(!empty($siteConfig['phone']))<div class="contact-method"><span>☎</span><div><b>{{ __('Call Us') }}</b><p><a href="tel:{{ preg_replace('/[^\d+]/','',$siteConfig['phone']) }}">{{ $siteConfig['phone'] }}</a></p></div></div>@endif
    @if(!empty($siteConfig['email']))<div class="contact-method"><span>✉</span><div><b>{{ __('Send Email') }}</b><p><a href="mailto:{{ $siteConfig['email'] }}">{{ $siteConfig['email'] }}</a></p></div></div>@endif
    @if(!empty($siteConfig['whatsapp']))<a class="elegant-link" target="_blank" rel="noopener noreferrer" href="https://wa.me/{{ preg_replace('/\D/','',$siteConfig['whatsapp']) }}">{{ __('Chat on WhatsApp') }} ↗</a>@endif
  </div>
  <div class="contact-form-shell"><span class="editorial-label">{{ $ar?'أرسل استفسارك':'SEND AN ENQUIRY' }}</span><h3>{{ $ar?'كيف يمكننا مساعدتك؟':'How can we help?' }}</h3><p>{{ $ar?'أكمل النموذج وسيتواصل معك فريقنا.':'Complete the form and our team will get in touch.' }}</p>
    <form class="stack premium-form" method="post" action="{{ route('inquiries.store') }}">@csrf
      <input name="website" type="text" hidden tabindex="-1" autocomplete="off">
      <div class="two-col"><div class="field"><label>{{ __('Full Name') }} *</label><input name="name" value="{{ old('name') }}" required maxlength="100"></div><div class="field"><label>{{ __('Phone Number') }} *</label><input name="phone" type="tel" value="{{ old('phone') }}" required maxlength="25"></div></div>
      <div class="field"><label>{{ __('Email Address') }}</label><input name="email" type="email" value="{{ old('email') }}"></div>
      <div class="field"><label>{{ __('Interest') }}</label><select name="purpose"><option value="buy">{{ __('Buy Property') }}</option><option value="rent">{{ __('Rent Property') }}</option><option value="invest">{{ __('Invest') }}</option><option value="general">{{ __('General Inquiry') }}</option></select></div>
      <div class="field"><label>{{ __('Message') }} *</label><textarea name="message" rows="5" minlength="10" maxlength="4000" required>{{ old('message') }}</textarea></div>
      <button type="submit" class="btn contact-submit">{{ $ar?'إرسال الاستفسار':'Send enquiry' }} ↗</button>
    </form>
  </div>
</div></section>
<section class="contact-photo-banner"><div class="container"><span>✧ {{ $ar?'الشارقة ودولة الإمارات العربية المتحدة':'SHARJAH & THE UNITED ARAB EMIRATES' }}</span><h2>{{ $ar?'معرفة محلية.':'Rooted in place.' }}<br>{{ $ar?'ورؤية تضع الإنسان أولاً.':'Focused on people.' }}</h2></div></section>
@endsection
