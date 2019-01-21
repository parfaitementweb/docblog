@extends('docblog::docs.layouts.master')

@section('title', ucfirst($tag->name) . ' - ' . __('docblog::docs.title'))
@section('description', __('docblog::ocs.description_tags', ['tag' => ucfirst($tag->name)]))

@section('meta')
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}"/>
    <meta property="og:type" content="object"/>
    <meta property="og:title" content="{{__('docblog::docs.title')}}"/>
    <meta property="og:description" content="{{__('docblog::docs.description')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:site_name" content="{{ucfirst($tag->name)}} - {{ config('docblog.name') }} Docs"/>
    <meta property="article:publisher" content="{{ config('docblog.og.publisher') }}"/>
    <meta property="article:published_time" content="{{now()->format(DateTime::ATOM)}}"/>
    <meta property="article:modified_time" content="{{now()->format(DateTime::ATOM)}}"/>
    <meta property="og:updated_time" content="{{now()->format(DateTime::ATOM)}}"/>
    <meta property="og:image" content="{{ asset(config('docblog.og.image')) }}"/>
    <meta property="og:image:secure_url" content="{{ asset(config('docblog.og.image')) }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{__('docblog::docs.title')}}"/>
    <meta name="twitter:description" content="{{__('docblog::docs.description')}}"/>
    <meta name="twitter:site" content="{{ config('docblog.links.social.twitter_handle') }}"/>
    <meta name="twitter:image" content="{{ asset(config('docblog.og.image')) }}"/>
    <meta name="twitter:creator" content="{{ config('docblog.links.social.twitter_handle') }}"/>

    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if($localeCode == config('app.fallback_locale'))
            <link rel="alternate" hreflang="x-default" href="{{locale_url('docs/tags/' . $tag->getTranslationWithoutFallback('name', $localeCode), $localeCode)}}"/>
        @else
            <link rel="alternate" hreflang="{{$localeCode}}" href="{{locale_url('docs/tags/' . $tag->getTranslationWithoutFallback('name', $localeCode), $localeCode)}}"/>
        @endif
    @endforeach

@endsection

@section('content')

    {{ Breadcrumbs::view('breadcrumbs::json-ld', 'tag', $tag) }}
    {{ Breadcrumbs::view('docblog::docs._partials.breadcrumbs', 'tag', $tag) }}

    <section>

        <h2 class="category">{{$tag->name}}</h2>

        @foreach($docs as $doc)
            <h3 class="doc-title"><a href="{{url($doc->url())}}">{{ $doc->title }}</a></h3>
        @endforeach

    </section>

@endsection