<?php

namespace Parfaitementweb\DocBlog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Parfaitementweb\DocBlog\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\Media;

class DocsController extends Controller
{
    public function index()
    {
        $docs = Doc::orderBy('publish_date', 'desc')->get();

        return view('docblog::admin.docs.index', compact('docs'));
    }

    public function create()
    {
        $doc = new Doc();

        $doc->publish_date = now();

        $force_lang = session('force_lang', config('app.fallback_locale'));
        return view('docblog::admin.docs.create', compact('doc', 'force_lang'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lang' => 'required',
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required',
            'publish_date' => 'date',
            'published' => 'boolean',
            'tags_text' => 'present',
            'seo_title' => 'present',
            'seo_description' => 'present',
            'breadcrumb_title' => 'present',
            'upload' => 'file|image',
        ]);

        if ($validator->fails()) {

            return back()
                ->with('force_lang', $request->input('lang'))
                ->withErrors($validator)
                ->withInput();
        }

        $doc = (new Doc())->updateAttributes($request->all());

        flash()->success('Doc saved');

        return redirect()->action('\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@edit', $doc->id)->with('force_lang', $request->input('lang'));
    }

    public function edit(Doc $doc)
    {
        $force_lang = session('force_lang', config('app.fallback_locale'));

        return view('docblog::admin.docs.edit', compact('doc', 'force_lang'));
    }

    public function update(Request $request, Doc $doc)
    {
        $validator = Validator::make($request->all(), [
            'lang' => 'required',
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required',
            'publish_date' => 'date',
            'published' => 'boolean',
            'tags_text' => 'present',
            'seo_title' => 'present',
            'seo_description' => 'present',
            'breadcrumb_title' => 'present',
            'upload' => 'file|image',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('force_lang', $request->input('lang'))
                ->withErrors($validator)
                ->withInput();
        }

        $saved = $doc->updateAttributes($request->all());

        if (! $saved->published) {
            $saved->unsearchable();
        }

        flash()->success('Doc updated');

        return back()->with('force_lang', $request->input('lang'));
    }

    public function destroy(Doc $doc)
    {
        $doc->delete();

        flash()->success('The doc was deleted');

        return redirect('/admin/docs');
    }

    public function forget(Doc $doc)
    {
        $doc->forgetAllTranslations(request()->input('lang'));
        $doc->save();

        flash()->success('The ' . strtoupper(request()->input('lang')) . ' language was deleted');

        return back();
    }

    public function deleteMedia(Doc $doc, Media $media)
    {
        $media->delete();

        flash()->success('The media was deleted');

        return back();
    }
}
