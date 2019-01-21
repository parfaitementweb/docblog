@extends('docblog::docs.layouts.master')

@section('title', $seo['title'] . ' - ' . __('docblog::docs.title'))
@section('description', $seo['description'])

@section('meta')
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$seo['title']}}"/>
    <meta property="og:description" content="{{$seo['description']}}"/>
    <meta property="og:url" content="{{url($doc->url())}}"/>
    <meta property="og:site_name" content="{{__('docblog::docs.title')}}"/>
    <meta property="article:publisher" content="{{ config('docblog.og.publisher') }}"/>
    @if($doc->tags->count() > 0)
        <meta property="article:section" content="{{ucfirst($doc->tags[0]->name)}}"/>
    @endif
    <meta property="article:published_time" content="{{$doc->publish_date->format(DateTime::ATOM)}}"/>
    <meta property="article:modified_time" content="{{$doc->publish_date->format(DateTime::ATOM)}}"/>
    <meta property="og:updated_time" content="{{$doc->publish_date->format(DateTime::ATOM)}}"/>
    <meta property="og:image" content="{{ asset(config('docblog.og.image')) }}"/>
    <meta property="og:image:secure_url" content="{{ asset(config('docblog.og.image')) }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{$seo['title']}}"/>
    <meta name="twitter:description" content="{{$seo['description']}}"/>
    <meta name="twitter:site" content="{{ config('docblog.links.social.twitter_handle') }}"/>
    <meta name="twitter:image" content="{{ asset(config('docblog.og.image')) }}"/>
    <meta name="twitter:creator" content="{{ config('docblog.links.social.twitter_handle') }}"/>

    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if($localeCode == config('app.fallback_locale'))
            @if($doc->exists($localeCode))
                <link rel="alternate" hreflang="x-default" href="{{$doc->url($localeCode)}}"/>
            @endif
        @else
            @if($doc->exists($localeCode))
                <link rel="alternate" hreflang="{{$localeCode}}" href="{{$doc->url($localeCode)}}"/>
            @endif
        @endif
    @endforeach
@endsection

@section('content')

    {{ Breadcrumbs::view('breadcrumbs::json-ld', 'doc', $doc) }}
    {{ Breadcrumbs::view('docblog::docs._partials.breadcrumbs', 'doc', $doc) }}

    <article>
        <div class="title">
            <h1>{{$doc->title}}</h1>
        </div>

        <div class="content">
            {!!  $doc->text !!}
        </div>

        <div class="navigation">
            {{__('docblog::docs.stuck')}} <a href="{{locale_url('contact')}}">{{__('docblog::docs.contact')}}</a>.
        </div>
    </article>

@endsection