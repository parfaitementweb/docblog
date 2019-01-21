@extends('docblog::docs.layouts.master')

@section('content')

    {{ Breadcrumbs::view('breadcrumbs::json-ld', 'docs') }}
    {{ Breadcrumbs::view('docblog::docs._partials.breadcrumbs', 'docs') }}

    <section>

        @foreach ($docs as $key => $elements)

            <h2 class="category">{{$key}}</h2>

            @foreach($elements as $doc)
                <h3 class="doc-title"><a href="{{url($doc->url())}}">{{ ucfirst($doc->title) }}</a></h3>
            @endforeach
        @endforeach

    </section>

@endsection