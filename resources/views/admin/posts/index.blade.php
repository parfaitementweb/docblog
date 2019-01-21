@extends('docblog::admin.layouts.master')

@section('content')

    <div class="text-right">
        <a href="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@create') }}" class="btn btn-success mb-3 float-right">New Post</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Date</th>
                <th scope="col">Status {{strtoupper(implode(' | ', LaravelLocalization::getSupportedLanguagesKeys()))}}</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td><a href="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@edit', $post->id) }}">{{ $post->title }}</a></td>
                    <td>{{ $post->publish_date }}</td>
                    <td>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            {{ $post->exists($localeCode) ? 'Published' : 'Draft' }} {{($loop->last) ? '' : '|'}}
                        @endforeach
                    </td>
                    <td>@include('docblog::admin._partials.deleteButton', ['url' => action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@destroy', [$post->id])])</td>
                </tr>
            @endforeach
            @if(count($posts) == 0)
                <tr>
                    <td colspan="5">No result</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection