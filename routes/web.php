<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware('web')->group(function () {

    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localizationRedirect', 'cacheResponse']], function () {
        Route::feeds();
    });

    if (config('docblog.enable_blog')) {
        Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localizationRedirect', 'cacheResponse']], function () {
            Route::get('blog/', '\Parfaitementweb\DocBlog\Http\Controllers\BlogController@index')->name('blog');
            Route::get('blog/{slug}', '\Parfaitementweb\DocBlog\Http\Controllers\BlogController@show');
        });
    }

    if (config('docblog.enable_doc')) {
        Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localizationRedirect', 'cacheResponse']], function () {
            Route::get('docs/', '\Parfaitementweb\DocBlog\Http\Controllers\DocsController@index')->name('docs');
            Route::get('docs/tags/{tag}', '\Parfaitementweb\DocBlog\Http\Controllers\DocsController@tags');
            Route::get('docs/search', '\Parfaitementweb\DocBlog\Http\Controllers\DocsController@search');
            Route::get('docs/{slug}', '\Parfaitementweb\DocBlog\Http\Controllers\DocsController@show');
        });
    }

    Route::middleware(['docblog_auth'])->group(function () {
        Route::get('admin', function () {
            if (config('docblog.enable_blog')) {
                return redirect('admin/posts');
            } elseif (config('docblog.enable_doc')) {
                return redirect('admin/docs');
            }

            abort(404);

        })->name('admin');

        if (config('docblog.enable_blog')) {
            Route::get('admin/posts/{post}/forget', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@forget')->name('posts.forget');
            Route::get('admin/posts/{post}/media/{media}/destroy', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController@deleteMedia')->name('posts.deleteMedia');
            Route::resource('admin/posts', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\PostsController');
        }

        if (config('docblog.enable_doc')) {
            Route::get('admin/docs/{doc}/forget', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@forget')->name('docs.forget');
            Route::get('admin/docs/{doc}/media/{media}/destroy', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController@deleteMedia')->name('docs.deleteMedia');
            Route::resource('admin/docs', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\DocsController');
        }

        Route::get('admin/tags/{tag}/moveUp', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\TagsController@moveUp');
        Route::get('admin/tags/{tag}/moveDown', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\TagsController@moveDown');
        Route::resource('admin/tags', '\Parfaitementweb\DocBlog\Http\Controllers\Admin\TagsController');
    });

    Route::get('admin/login', '\Parfaitementweb\DocBlog\Http\Controllers\Auth\LoginController@showLoginForm')->name('docblog::login');
    Route::post('admin/login', '\Parfaitementweb\DocBlog\Http\Controllers\Auth\LoginController@login');
    Route::post('admin/logout', '\Parfaitementweb\DocBlog\Http\Controllers\Auth\LoginController@logout')->name('docblog::logout');
});