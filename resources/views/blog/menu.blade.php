<ul class="navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="{{ locale_url('blog')  }}">@lang('docblog::blog.blog_home')</a>
    </li>
    @if(config('docblog.enable_doc'))
        <li class="nav-item">
            <a class="nav-link" target="_blank" href="{{ locale_url('docs') }}">@lang('docblog::docs.home')</a>
        </li>
    @endif
</ul>
@if(count($languages) > 1)
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        @isset($is_detail)
            @foreach($languages as $localeCode => $properties)
                @isset($post)
                    @if($post->exists($localeCode))
                        <li class="nav-item">
                            <a class="nav-link small" title="{{$properties['native']}}" href="{{ locale_url('blog/' . $post->getTranslation('slug', $localeCode), $localeCode) }}">{{$properties['native']}}
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach
        @else
            @foreach($languages as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link small" title="{{$properties['native']}}" href="{{ locale_url('blog/', $localeCode)}}">{{$properties['native']}}</a>
                </li>
            @endforeach
        @endif
    </ul>
@endif