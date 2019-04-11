<?php

namespace Parfaitementweb\DocBlog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Parfaitementweb\DocBlog\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\Models\Media;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('publish_date', 'desc')->get();

        return view('docblog::admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post();

        $post->publish_date = now();

        $force_lang = session('force_lang', config('app.fallback_locale'));
        return view('docblog::admin.posts.create', compact('post', 'force_lang'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lang' => 'required',
            'title' => 'required',
            'text' => 'required',
            'excerpt' => 'required',
            'slug' => 'required',
            'publish_date' => 'date',
            'published' => 'boolean',
            'tags_text' => 'present',
            'seo_title' => 'present',
            'seo_description' => 'present',
            'redirect' => 'present',
            'upload' => 'file|image',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('force_lang', $request->input('lang'))
                ->withErrors($validator)
                ->withInput();
        }

        $post = (new Post())->updateAttributes($request->all());

        flash()->success('Post saved');

        return redirect()->action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@edit', $post->id)->with('force_lang', $request->input('lang'));
    }

    public function edit(Post $post)
    {
        $force_lang = session('force_lang', config('app.fallback_locale'));

        return view('docblog::admin.posts.edit', compact('post', 'force_lang'));
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'lang' => 'required',
            'title' => 'required',
            'text' => 'required',
            'excerpt' => 'required',
            'slug' => 'required',
            'publish_date' => 'date',
            'published' => 'boolean',
            'tags_text' => 'present',
            'seo_title' => 'present',
            'seo_description' => 'present',
            'redirect' => 'present',
            'upload' => 'file|image',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('force_lang', $request->input('lang'))
                ->withErrors($validator)
                ->withInput();
        }

        $post->updateAttributes($request->all());

        flash()->success('Post updated');

        return back()->with('force_lang', $request->input('lang'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        flash()->success('The post was deleted');

        return redirect('/admin/posts');
    }

    public function forget(Post $post)
    {
        $post->forgetAllTranslations(request()->input('lang'));
        $post->save();

        flash()->success('The ' .strtoupper(request()->input('lang')). ' language was deleted');

        return back();
    }

    public function deleteMedia(Post $post, Media $media)
    {
        $media->delete();

        flash()->success('The media was deleted');

        return back();
    }
}
