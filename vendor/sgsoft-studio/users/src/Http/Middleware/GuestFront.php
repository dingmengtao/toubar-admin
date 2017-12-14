<?php namespace WebEd\Base\Users\Http\Middleware;

use \Closure;

class GuestFront
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth(config('webed-auth.front_actions.guard'))->check()) {
            return redirect()->to(asset(''));
        }

        return $next($request);
    }
}
