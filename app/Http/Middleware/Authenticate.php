<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // dd($request);
        // dd($request->server['parameters']);
        if (! $request->expectsJson()) {
            // return redirect()->route('login');

            // return redirect()->route('front.user.login');

            if($request->is('admin') || $request->is('admin/*'))
            return redirect()->route('admin.login');

            return redirect()->route('front.user.login');
        }
    }
}
