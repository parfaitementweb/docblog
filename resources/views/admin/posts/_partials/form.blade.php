{!! csrf_field() !!}

<div class="row">
    <div class="col-md-8">

        <div class="form-group">
            <label for="publish_date">Slug [{{strtoupper($lang)}}]</label>
            <input class="form-control" id="slug" name="slug" value="{{ ($lang == $force_lang) ? old('slug', $post->getTranslationWithoutFallback('slug', $lang)) : $post->getTranslationWithoutFallback('slug', $lang) }}" required>
            @if($errors->has('slug'))
                <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="title">Title [{{strtoupper($lang)}}]</label>
            <input class="form-control {{ ($errors->has('title')) ? 'is-invalid': ''}}" id="title" name="title" value="{{ ($lang == $force_lang) ? old('title', $post->getTranslationWithoutFallback('title', $lang)) : $post->getTranslationWithoutFallback('title', $lang) }}"
                   required>
            @if($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="excerpt">Excerpt [{{strtoupper($lang)}}]</label>
            <textarea class="form-control {{ ($errors->has('excerpt')) ? 'is-invalid': ''}}" rows="17" id="excerpt-{{$lang}}" name="excerpt"
                      required>{{ ($lang == $force_lang) ? old('excerpt', $post->getTranslationWithoutFallback('excerpt', $lang)) : $post->getTranslationWithoutFallback('excerpt', $lang) }}</textarea>
            @if($errors->has('excerpt'))
                <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="text">Text [{{strtoupper($lang)}}]</label>
            <textarea class="form-control {{ ($errors->has('text')) ? 'is-invalid': ''}}" rows="50" id="text-{{$lang}}" name="text"
                      required>{{ ($lang == $force_lang) ? old('text', $post->getTranslationWithoutFallback('text', $lang)) : $post->getTranslationWithoutFallback('text', $lang) }}</textarea>
            @if($errors->has('text'))
                <div class="invalid-feedback">{{ $errors->first('text') }}</div>
            @endif
        </div>

        <div class="card mb-3">
            <div class="card-header">
                SEO
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="seo_title">Title [{{strtoupper($lang)}}]</label>
                    <input class="form-control {{ ($errors->has('seo_title')) ? 'is-invalid': ''}}" id="seo_title" name="seo_title" placeholder="%title%"
                           value="{{ ($lang == $force_lang) ? old('seo_title', $post->getTranslationWithoutFallback('seo_title', $lang)) : $post->getTranslationWithoutFallback('seo_title', $lang) }}">
                    @if($errors->has('seo_title'))
                        <div class="invalid-feedback">{{ $errors->first('seo_title') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="seo_description">Description [{{strtoupper($lang)}}]</label>
                    <input class="form-control {{ ($errors->has('seo_description')) ? 'is-invalid': ''}}" id="seo_description" placeholder="%excerpt%" name="seo_description"
                           value="{{ ($lang == $force_lang) ? old('seo_description', $post->getTranslationWithoutFallback('seo_description', $lang)) : $post->getTranslationWithoutFallback('seo_description', $lang) }}">
                    @if($errors->has('seo_description'))
                        <div class="invalid-feedback">{{ $errors->first('seo_description') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="redirect">Redirect 301</label>

                    <select class="form-control {{ ($errors->has('redirect')) ? 'is-invalid': ''}}" name="redirect" id="redirect">
                        <option value="" {{ (old('redirect', $post->redirect) == null) ? 'selected':'' }}>None</option>
                        @foreach(\Parfaitementweb\DocBlog\Models\Post::all() as $all_blog)
                            <option value="{{$all_blog->id}}" {{ (old('redirect', $post->redirect) == $all_blog->id) ? 'selected':'' }}>{{$all_blog->getTranslationWithFallback('title', $lang)}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('redirect'))
                        <div class="invalid-feedback">{{ $errors->first('redirect') }}</div>
                    @endif
                </div>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                Author
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="seo_title">Author [{{strtoupper($lang)}}]</label>
                    <input class="form-control {{ ($errors->has('author')) ? 'is-invalid': ''}}" id="author" name="author" placeholder="{{config('docblog.default_author')}}"
                           value="{{ old('author', $post->author ?? config('docblog.default_author')) }}">
                    @if($errors->has('author'))
                        <div class="invalid-feedback">{{ $errors->first('author') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                Media
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="upload">Upload a file</label>
                    <input type="file" class="form-control-file" name="upload" id="upload" style="overflow: hidden">
                    @if($errors->has('upload'))
                        <div class="invalid-feedback">{{ $errors->first('upload') }}</div>
                    @endif
                    <hr>
                </div>

                <div class="d-flex">
                    @foreach($post->getMedia() as $media )

                        <div class="card mr-3" style="max-width: 250px;">
                            <img class="card-img-top" src="{{$media->getUrl('thumb')}}" alt="Card image cap">
                            <div class="card-body">

                                <input type="text" class="form-control w-100" value="{{$media->getUrl($media->name)}}">

                                <small class="card-title">{{$media->file_name}}</small>
                                <div class="d-flex mt-3">
                                    <a href="{{url($media->getUrl($media->name))}}" class="card-link" target="_blank">Link</a>
                                    <a onclick="return confirm('Confirm DELETE?')" href="{{action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@deleteMedia', ['post' => $post->id, 'media' => $media->getKey()])}}" class="card-link text-danger">Delete</a>
                                </div>
                            </div>

                        </div>

                    @endforeach
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="publish_date">Publish date</label>
            <input class="form-control" id="publish_date" name="publish_date" value="{{ old('publish_date', $post->publish_date->format('Y-m-d H:i:s')) }}" required>
            @if($errors->has('publish_date'))
                <div class="invalid-feedback">{{ $errors->first('publish_date') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <input class="form-control" id="tags" name="tags_text" value="{{ old('tags_text', $post->tags_text) }}">
            @if($errors->has('tags_text'))
                <div class="invalid-feedback">{{ $errors->first('tags_text') }}</div>
            @endif
        </div>

        <div class="form-group form-checkbox">
            <input class="mr-2" name="published" value="1" type="checkbox" {{ $post->getTranslationWithoutFallback('published', $lang) ? 'checked' : '' }}> Published
        </div>

        <div class="form-group">
            <a href="{{ url($post->url($lang))  }}" target="_blank"
               class="btn btn-block btn-outline-primary {{(!$post->getTranslationWithoutFallback('published', $lang) ? 'disabled' : '')}}">View post</a>
            <button type="submit" class="btn btn-primary btn-block">{{$submitText}}</button>
        </div>

        <div class="form-group text-right">
            <a onclick="return confirm('Confirm DELETE?')" href="{{ action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@forget', ['post' => $post->id, 'lang' => $lang]) }}" class="btn btn-danger btn-sm">Delete
                [{{strtoupper($lang)}}] language</a>
        </div>

    </div>
</div>

@section('scripts')
    <script>
        // CKEDITOR.replaceAll();

        $(document).ready(function() {
            $('textarea').each(function() {
                if ($(this).attr('rows')) {
                    CKEDITOR.replace($(this).attr('id'),
                        {
                            height: $(this).attr('rows') * 10
                        });
                }
            });
        });
    </script>
@endsection