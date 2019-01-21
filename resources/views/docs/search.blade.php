@extends('docblog::docs.layouts.master')


@section('meta')
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}"/>
    <meta property="og:type" content="object"/>
    <meta property="og:title" content="{{__('docblog::docs.title')}}"/>
    <meta property="og:description" content="{{__('docblog::docs.description')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:site_name" content="{{ucfirst($term)}} - {{ config('docblog.name') }} Docs"/>
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

    <link rel="alternate" hreflang="x-default" href="{{url('docs/search?query=' . $term)}}"/>
    <link rel="alternate" hreflang="fr" href="{{url('docs/fr/search?query=' . $term)}}"/>
@endsection

@section('content')

    {{ Breadcrumbs::view('breadcrumbs::json-ld', 'search') }}
    {{ Breadcrumbs::view('docblog::docs._partials.breadcrumbs', 'search') }}

    <section>

        <h2 class="category">Results for "{{$term}}"</h2>

        @foreach($results as $doc)
            <h3 class="doc-title"><a href="{{url($doc->url())}}">{{ $doc->title }}</a></h3>
        @endforeach

        @if($results->count() == 0)
            <p>No result.</p>
        @endif

        {{ $results->links() }}

    </section>

@endsection