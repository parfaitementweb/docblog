<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <a class="navbar-brand" href="{{url('admin')}}">Admin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(config('docblog.enable_blog'))
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/posts')}}">Blog <span class="sr-only">(current)</span></a>
            </li>
            @endif
            @if(config('docblog.enable_doc'))
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/docs')}}">Docs <span class="sr-only">(current)</span></a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/tags')}}">Tags <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>

    @include('docblog::admin.layouts._partials.logout')
</nav>