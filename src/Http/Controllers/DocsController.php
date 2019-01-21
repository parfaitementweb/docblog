<?php

namespace Parfaitementweb\DocBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Parfaitementweb\DocBlog\Models\Doc;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class DocsController extends Controller
{
    public function index()
    {
        $docs = Doc::where('published->' . app()->getLocale(), true)->orderBy('publish_date', 'desc')->get()->sortBy(function ($item, $key) {
            if ($item->tags->first()) {
                return $item->tags->first()->order_column;
            }

            return 999;
        })->groupBy([
            function ($item) {
                if ($item->tags->first()) {
                    return $item->tags->first()->name;
                }

                return 'uncategorized';

            },
        ], $preserveKeys = true);

        return view('docblog::docs.index', compact('docs'));
    }

    public function show($slug)
    {
        $doc = Doc::where('slug->' . app()->getLocale(), $slug)->first() ?? abort(404);

        if (! $doc->getTranslation('published', app()->getLocale()) && ! auth()->check()) {
            abort(404);
        }

        $seo['title'] = $this->seoTitle($doc);
        $seo['description'] = $this->seoDescription($doc);

        return view('docblog::docs.detail', compact('doc', 'seo'))->with('is_detail', true);
    }

    public function tags($tagName)
    {
        $tag = Tag::findFromString($tagName);

        if (! $tag) {
            abort(404);
        }

        $docs = Doc::withAnyTags([$tag])->where('published->' . app()->getLocale(), true)->get();

        return view('docblog::docs.tagged', compact('tag', 'docs'));
    }

    private function seoTitle(Doc $doc)
    {
        return (! empty($doc->seo_title)) ? $doc->seo_title : mb_strimwidth(trim(preg_replace('/[\r\n\t ]+/', ' ', strip_tags($doc->title))), 0, 70, "...");
    }

    private function seoDescription(Doc $doc)
    {
        return (! empty($doc->seo_description)) ? $doc->seo_description : mb_strimwidth(trim(preg_replace('/[\r\n\t ]+/', ' ', strip_tags($doc->title))), 0, 300, "...");
    }

    public function search(Request $request)
    {
        $term = $request->input('query');
        $results = Doc::search($term)->paginate(100);

        return view('docblog::docs.search', compact('term', 'results'))->with('is_detail', true);
    }

}
