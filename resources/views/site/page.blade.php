@extends('layouts.site')
@section('title',$page->title)
@section('content')<div class="page-hero"><div class="container"><span class="kicker">AL HASM PROPERTIES</span><h1>{{ $page->title }}</h1><div class="breadcrumbs"><a href="{{ route('home') }}">{{ __('Home') }}</a> / {{ $page->title }}</div></div></div><section class="section"><div class="container" style="max-width:850px"><div class="prose">{{ $page->body }}</div></div></section>@endsection
