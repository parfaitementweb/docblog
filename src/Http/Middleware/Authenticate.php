<?php

namespace Parfaitementweb\DocBlog\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect('admin/login');
        }

        if (! in_array(Auth::user()->email, config('docblog.admins'))) {
            Auth::logout();
            return redirect('admin/login');
        }

        return $next($request);
    }
}
