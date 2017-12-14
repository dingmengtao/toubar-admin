<?php namespace WebEd\Base\Users\Http\Middleware;

use \Closure;

class AuthenticateAdmin
{
    const LOGIN_ROUTE_NAME_GET = 'admin::auth.login.get';

    const LOGIN_ROUTE_NAME_POST = 'admin::auth.login.post';

    const DASHBOARD_CHANGE_LANGUAGE = 'admin::dashboard-language.get';

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

        if (auth(config('webed-auth.guard'))->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response_with_messages('Unauthorized.', true, \Constants::UNAUTHORIZED_CODE);
            }
            return redirect()->guest(route($this::LOGIN_ROUTE_NAME_GET));
        }

        dashboard_menu()->setUser($request->user());

        return $next($request);
    }

    /**
     * @param string $routeName
     * @return bool
     */
    protected function checkAllowedRoutes($routeName)
    {
        if ($routeName === $this::LOGIN_ROUTE_NAME_GET || $routeName === $this::LOGIN_ROUTE_NAME_POST || $routeName === $this::DASHBOARD_CHANGE_LANGUAGE) {
            return true;
        }

        return false;
    }
}
