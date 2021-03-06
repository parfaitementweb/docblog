@extends('docblog::admin.layouts.master')

@section('content')

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li class="nav-item">
                <a class="nav-link {{($force_lang == $localeCode) ? 'active' : ''}}" id="{{$localeCode}}-tab" data-toggle="tab" href="#{{$localeCode}}" role="tab" aria-controls="en" aria-selected="true">{{$properties['native']}}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">

        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

            <div class="tab-pane show {{($force_lang == $localeCode) ? 'active' : ''}}" id="{{$localeCode}}" role="tabpanel" aria-labelledby="{{$localeCode}}-tab">
                <form method="POST" action="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@update', $doc->id) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="lang" value="{{$localeCode}}">
                    @include('docblog::admin.docs._partials.form', ['lang' => $localeCode, 'submitText' => 'Update [' . strtoupper($localeCode).']'] )
                </form>
            </div>

        @endforeach

        <form action="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@destroy', ['doc' => $doc->id]) }}" method="POST" onsubmit="return confirm('!!! Delete ENTIRE article? !!!');">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="btn btn-outline-danger btn-sm mb-3" title="Delete">
                Delete article
            </button>
        </form>

    </div>

@endsection