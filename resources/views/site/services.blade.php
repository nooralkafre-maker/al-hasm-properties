@extends('layouts.site')
@section('title',__('Our Services'))
@section('content')
@php($ar=app()->getLocale()==='ar')
<section class="inner-hero service-hero"><div class="container inner-hero-content"><span class="editorial-label light">{{ $ar?'تجربة عقارية مدروسة':'A MORE CONSIDERED PROPERTY JOURNEY' }}</span><h1>{{ $ar?'أكثر من':'More than' }}<br><em>{{ $ar?'مجرد صفقة.':'a transaction.' }}</em></h1><p>{{ $ar?'خدمات عقارية شخصية تناسب موقعك الحالي وطموحاتك المستقبلية.':'Personal real estate services built around where you are and where you want to go.' }}</p></div></section>
<section class="section"><div class="container"><div class="heading premium-heading"><div><span class="editorial-label">01 / {{ $ar?'كيف يمكننا مساعدتك':'HOW WE CAN HELP' }}</span><h2>{{ $ar?'خدمات صممت':'Services designed' }}<br><em>{{ $ar?'من أجلك.':'around you.' }}</em></h2></div></div><div class="services-detailed">
@foreach([
 ['⌂','Buying a Property','شراء العقارات','Discover homes and investment opportunities that align with your goals.','اكتشف منازل وفرصًا تتناسب مع أهدافك.'],
 ['⚿','Renting a Home','تأجير العقارات','Find a home that suits your budget, location and lifestyle.','اعثر على منزل يناسب ميزانيتك وموقعك وأسلوب حياتك.'],
 ['◇','Investment Guidance','استشارات الاستثمار','Explore opportunities with an informed view of location and property features.','استكشف الفرص بنظرة مدروسة للموقع ومميزات العقار.'],
 ['✦','Property Marketing','تسويق العقارات','Showcase your property through attractive and clear listings.','اعرض عقارك بصورة جذابة ومعلومات واضحة.'],
 ['♧','Viewing Coordination','تنسيق المعاينات','Arrange property viewings and receive status updates.','نسّق مواعيد معاينة العقارات وتابع الطلبات.'],
 ['↗','Personal Consultation','استشارات شخصية','Get support tailored to your next property move.','احصل على دعم يناسب خطوتك العقارية القادمة.']
] as $i=>$service)
<div class="service-detail-card"><span class="service-detail-count">0{{ $i+1 }} / 06</span><span class="service-detail-icon">{{ $service[0] }}</span><h3>{{ $ar?$service[2]:$service[1] }}</h3><p>{{ $ar?$service[4]:$service[3] }}</p><a href="{{ route('contact') }}" class="elegant-link">{{ $ar?'استفسر الآن':'Enquire now' }} ↗</a></div>
@endforeach
</div></div></section>
<section class="closing-cta"><div class="container"><span class="editorial-label light">{{ $ar?'كيف يمكننا مساعدتك؟':'HOW CAN WE HELP?' }}</span><h2>{{ $ar?'خططك،':'Your plans,' }}<br><em>{{ $ar?'محور اهتمامنا.':'our attention.' }}</em></h2><a href="{{ route('contact') }}" class="btn hero-primary">{{ __('Contact Our Team') }} ↗</a></div></section>
@endsection
