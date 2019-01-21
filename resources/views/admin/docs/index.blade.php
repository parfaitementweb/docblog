@extends('docblog::admin.layouts.master')

@section('content')

    <div class="text-right">
        <a href="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@create') }}" class="btn btn-success mb-3 float-right">New Doc</a>
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
            @foreach($docs as $doc)
                <tr>
                    <th scope="row">{{$doc->id}}</th>
                    <td><a href="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@edit', $doc->id) }}">{{ $doc->title }}</a></td>
                    <td>{{ $doc->publish_date }}</td>
                    <td>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            {{ $doc->exists($localeCode) ? 'Published' : 'Draft' }} {{($loop->last) ? '' : '|'}}
                        @endforeach
                    </td>
                    <td>@include('docblog::admin._partials.deleteButton', ['url' => action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@destroy', [$doc->id])])</td>
                </tr>
            @endforeach
            @if(count($docs) == 0)
                <tr>
                    <td colspan="5">No result</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection