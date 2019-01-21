<?php

namespace Parfaitementweb\DocBlog\ViewComposers\Blog;

use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MenuComposer
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
        $languages = LaravelLocalization::getSupportedLocales();
        $view->with(compact('languages'));
    }
}