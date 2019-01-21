<ul>
    @foreach($tags as $key => $tag)
        <li><a href="{{ locale_url('docs/tags/'.$key) }}">{{ucfirst($key)}}</a></li>
    @endforeach
</ul>