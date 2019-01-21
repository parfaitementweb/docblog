<?php

namespace Parfaitementweb\DocBlog\Facades;

use Illuminate\Support\Facades\Facade;

class Docblog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'docblog';
    }
}
