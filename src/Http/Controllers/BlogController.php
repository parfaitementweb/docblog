<?php

namespace Parfaitementweb\DocBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Parfaitementweb\DocBlog\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where('published->' . app()->getLocale(), true)->orderBy('publish_date', 'desc')->simplePaginate(10);
        return view('docblog::blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug->' . app()->getLocale(), $slug)->first() ?? abort(404);

        if ( ! $post->getTranslation('published', app()->getLocale()) && !auth()->check()) {
            abort(404);
        }

        $seo['title'] = $this->seoTitle($post);
        $seo['description'] = $this->seoDescription($post);

        return view('docblog::blog.detail', compact('post', 'seo'))->with('is_detail', true);
    }

    private function seoTitle(Post $post) {
        return (!empty($post->seo_title)) ? $post->seo_title : mb_strimwidth(trim(preg_replace('/[\r\n\t ]+/', ' ', strip_tags($post->title))), 0 , 70, "..." );
    }

    private function seoDescription(Post $post) {
        return (!empty($post->seo_description)) ? $post->seo_description : mb_strimwidth(trim(preg_replace('/[\r\n\t ]+/', ' ', strip_tags($post->excerpt))), 0 , 300, "..." );
    }
}
