<?php

namespace Parfaitementweb\DocBlog\ViewComposers\Docs;

use Parfaitementweb\DocBlog\Models\Doc;
use Illuminate\View\View;
use Spatie\Tags\Tag;

class CategoriesComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $tags = Doc::where('published->' . app()->getLocale(), true)->get()->groupBy([
            function ($item) {
                if ($item->tags->first()) {
                    return $item->tags->first()->name;
                }
                return 'uncategorized';

            },
        ], $preserveKeys = true);

        $view->with(compact('tags'));
    }
}