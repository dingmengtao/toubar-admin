<?php namespace WebEd\Base\Users\Http\Middleware;

use \Closure;

class GuestAdmin
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth(config('webed-auth.guard'))->check()) {
            return redirect()->to(route('admin::dashboard.index.get'));
        }

        return $next($request);
    }
}
