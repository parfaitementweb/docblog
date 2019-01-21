@extends('docblog::blog.layouts.master')

@section('hero')

    <div class="title">
        <h1>@lang('docblog::blog.title')</h1>
        <p class="meta">@lang('docblog::blog.description')</p>
    </div>

@endsection

@section('content')

    <section>
        @foreach($posts as $post)
            <div class="content item-list">

                <h2><a href="{{url($post->url())}}">{{ ucfirst($post->title) }}</a></h2>
                <p class="meta">
                    <time datetime="{{ $post->publish_date->format(DateTime::ATOM) }}">
                        {{ $post->publish_date->format('F d, Y') }}
                    </time>
                    @lang('docblog::blog.by') {{$post->author}}
                    @if($post->tags->count() > 0)
                        <small>
                            | Tags:
                            @foreach($post->tags->sortBy->name as $tag)
                                {{ $tag->name }} &nbsp;
                            @endforeach
                        </small>
                    @endif
                </p>

                {!!  $post->excerpt !!}

                <p><a href="{{url($post->url())}}" class="more-link">@lang('docblog::blog.more')</a></p>

            </div>
        @endforeach

        {{ $posts->links() }}
    </section>

@endsection