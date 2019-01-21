@extends('docblog::admin.layouts.master')

@section('content')

    <table class="table">
        <thead>
        <tr>
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <th scope="col">{{strtoupper($localeCode)}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <form method="POST" action="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\TagsController@update', $tag->id) }}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                {!! csrf_field() !!}
                <tr>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <td>
                            <input name="{{$localeCode}}" type="text" value="{{$tag->getTranslationWithoutFallback('name', $localeCode)}}" {{ (config('app.fallback_locale') == $localeCode) ? 'disabled': '' }}>
                        </td>
                    @endforeach

                    <td>
                        <input type="submit" class="btn btn-success btn-sm" value="Save">
                        @if (!$loop->first)
                            <a href="{{action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\TagsController@moveUp', $tag->id)}}" class="btn btn-outline-primary btn-sm">Move Up</a>
                        @endif
                        @if (!$loop->last)
                            <a href="{{action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\TagsController@moveDown', $tag->id)}}" class="btn btn-outline-primary btn-sm">Move Down</a>
                        @endif
                    </td>
                </tr>
            </form>
        @endforeach
        </tbody>
    </table>

    </form>

@endsection