@extends('docblog::blog.layouts.master')

@section('title', $seo['title'] . ' - ' . __('docblog::blog.title'))
@section('description', $seo['description'])

@section('meta')
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$seo['title']}}"/>
    <meta property="og:description" content="{{$seo['description']}}"/>
    <meta property="og:url" content="{{url($post->url())}}"/>
    <meta property="og:site_name" content="{{__('docblog::blog.title')}}"/>
    <meta property="article:publisher" content="{{ config('docblog.og.publisher') }}"/>
    @if($post->tags->count() > 0)
        <meta property="article:section" content="{{ucfirst($post->tags[0]->name)}}"/>
    @endif
    <meta property="article:published_time" content="{{$post->publish_date->format(DateTime::ATOM)}}"/>
    <meta property="article:modified_time" content="{{$post->publish_date->format(DateTime::ATOM)}}"/>
    <meta property="og:updated_time" content="{{$post->publish_date->format(DateTime::ATOM)}}"/>
    <meta property="og:image" content="{{ asset(config('docblog.og.image')) }}"/>
    <meta property="og:image:secure_url" content="{{ asset(config('docblog.og.image')) }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{$seo['title']}}"/>
    <meta name="twitter:description" content="{{$seo['description']}}"/>
    <meta name="twitter:site" content="{{ config('docblog.links.social.twitter_handle') }}"/>
    <meta name="twitter:image" content="{{ asset(config('docblog.og.image')) }}"/>
    <meta name="twitter:creator" content="{{ config('docblog.links.social.twitter_handle') }}"/>

    <script type="application/ld+json">
    {
    "@context": "http://schema.org/",
    "@type": "WebSite",
    "name": "{{ config('docblog.name') }}",
    "url": "{{url('blog')}}"
    }
    </script>

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name":"{{ config('docblog.name') }}",
            "url": "{{url($post->url())}}",
            "logo": "{{ asset(config('docblog.og.image')) }}",
            "sameAs" : [
                "{{ config('docblog.links.social.facebook') }}",
                "{{ config('docblog.links.social.twitter') }}"
            ],
            "contactPoint" : [
                {
                    "@type" : "ContactPoint",
                    "contactType" : "customer support",
                    "url": "{{ config('docblog.links.website') }}",
                    "availableLanguage" : ["French","English"]
                },
                {
                    "@type" : "ContactPoint",
                    "contactType" : "sales",
                    "url": "{{ config('docblog.links.website') }}",
                    "availableLanguage" : ["French","English"]
                }
            ]
        }
    </script>

    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if($localeCode == config('app.fallback_locale'))
            @if($post->exists($localeCode))
                <link rel="alternate" hreflang="x-default" href="{{$post->url($localeCode)}}"/>
            @endif
        @else
            @if($post->exists($localeCode))
                <link rel="alternate" hreflang="{{$localeCode}}" href="{{$post->url($localeCode)}}"/>
            @endif
        @endif
    @endforeach
@endsection

@section('hero')
    <div class="title">
        <h1>{{ ucfirst($post->title) }}</h1>
        <p class="meta">
            <time datetime="{{ $post->publish_date->format(DateTime::ATOM) }}">
                {{ $post->publish_date->format('F d, Y') }}
            </time>
            @lang('docblog::blog.by') {{$post->author}}
        </p>
    </div>
@endsection

@section('content')
    <article>

        <div class="content article">
            {!!  $post->excerpt !!}
            {!!  $post->text !!}
        </div>

        <div class="navigation">
            <div class="nav-next"><a href="{{ locale_url('blog')  }}">@lang('docblog::blog.all_posts')</a></div>
        </div>

    </article>

@endsection