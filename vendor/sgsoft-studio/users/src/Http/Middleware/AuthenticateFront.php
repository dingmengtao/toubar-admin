<?php namespace WebEd\Base\Users\Http\Middleware;

use \Closure;

class AuthenticateFront
{
    const LOGIN_ROUTE_NAME_GET = 'front::auth.login.get';

    const LOGIN_ROUTE_NAME_POST = 'front::auth.login.post';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->checkAllowedRoutes($request->route()->getName())) {
            return $next($request);
        }

        if (auth(config('webed-auth.front_actions.guard'))->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response_with_messages('Unauthorized.', true, \Constants::UNAUTHORIZED_CODE);
            }
            return redirect()->guest(route($this::LOGIN_ROUTE_NAME_GET));
        }

        return $next($request);
    }

    /**
     * @param string $routeName
     * @return bool
     */
    protected function checkAllowedRoutes($routeName)
    {
        if ($routeName === $this::LOGIN_ROUTE_NAME_GET || $routeName === $this::LOGIN_ROUTE_NAME_POST) {
            return true;
        }

        return false;
    }
}
