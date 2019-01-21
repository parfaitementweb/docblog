<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>@yield('title', __('docblog::blog.title'))</title>
    <meta name="description" content="@yield('description', __('docblog::blog.description'))">
    <link rel="icon" type="image/png" href="{{asset(config('docblog.favicon'))}}"/>

    @section('meta')
        <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{__('docblog::blog.title')}}"/>
        <meta property="og:description" content="{{__('docblog::blog.description')}}"/>
        <meta property="og:url" content="{{url()->current()}}"/>
        <meta property="og:site_name" content="{{__('docblog::blog.title')}}"/>
        <meta property="article:publisher" content="{{ config('docblog.og.publisher') }}"/>
        <meta property="article:published_time" content="{{now()->format(DateTime::ATOM)}}"/>
        <meta property="article:modified_time" content="{{now()->format(DateTime::ATOM)}}"/>
        <meta property="og:updated_time" content="{{now()->format(DateTime::ATOM)}}"/>
        <meta property="og:image" content="{{ asset(config('docblog.og.image')) }}"/>
        <meta property="og:image:secure_url" content="{{ asset(config('docblog.og.image')) }}"/>

        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:title" content="{{__('docblog::blog.title')}}"/>
        <meta name="twitter:description" content="{{__('docblog::blog.description')}}"/>
        <meta name="twitter:site" content="{{ config('docblog.links.social.twitter_handle') }}"/>
        <meta name="twitter:image" content="{{ asset(config('docblog.og.image')) }}"/>
        <meta name="twitter:creator" content="{{ config('docblog.links.social.twitter_handle') }}"/>

        {{--NO ALTERNATE SINCE POST LISTING IS NOT THE SAME FOR ALL LANGUAGES--}}
    @show

    <script type="application/ld+json">
        {
        "@context": "http://schema.org/",
        "@type": "WebSite",
        "name": "{{__('docblog::blog.title')}}",
        "url": "{{locale_url('blog/')}}",
        }
    </script>

    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name":"{{ config('docblog.name') }}",
        "url": "{{ config('docblog.links.website') }}/",
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

    <link rel="stylesheet" href="{{ mix('css/blog.css') }}">

    <link rel="alternate" type="application/rss+xml" title="News" href="{{ locale_url('blog/feed') }}">
</head>
<body>

<div class="hero">

    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container mt-1 mb-1">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="{{locale_url('/')}}?utm_source=website&utm_content=blog"><img src="{{asset(config('docblog.logo'))}}" height="30" alt="{{ config('docblog.name') }}" class="d-inline-block"> {{config('docblog.name')}}</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                @include('docblog::blog.menu')
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        @yield('hero')
    </div>

</div>

<div class="container">
    @yield('content')
</div>

<noscript id="deferred-styles">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Roboto:300,400,500,600,700" rel="stylesheet">
</noscript>

<script>
    var loadDeferredStyles = function() {
        var addStylesNode = document.getElementById("deferred-styles");
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode.textContent;
        document.body.appendChild(replacement)
        addStylesNode.parentElement.removeChild(addStylesNode);
    };
    var raf = requestAnimationFrame || mozRequestAnimationFrame ||
        webkitRequestAnimationFrame || msRequestAnimationFrame;
    if (raf) raf(function() {
        window.setTimeout(loadDeferredStyles, 0);
    });
    else window.addEventListener('load', loadDeferredStyles);
</script>

@if(App::environment('production'))
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123482629-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{config('docblog.GA')}}', {});
    </script>
@endif

<script src="{{ mix('js/blog.js') }}"></script>
@yield('scripts')

</body>
</html>
