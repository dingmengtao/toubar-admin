<?php namespace WebEd\Base\ModulesManagement\Http\Middleware;

use \Closure;

class BootstrapModuleMiddleware
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        dashboard_menu()
            ->registerItem([
                'id' => 'webed-core-modules',
                'priority' => 1001,
                'parent_id' => null,
                'heading' => trans('webed-modules-management::base.admin_menu.core_modules.heading'),
                'title' => trans('webed-modules-management::base.admin_menu.core_modules.title'),
                'font_icon' => 'icon-rocket',
                'link' => route('admin::core-modules.index.get'),
                'css_class' => null,
                'permissions' => ['view-plugins'],
            ])
            ->registerItem([
                'id' => 'webed-plugins',
                'priority' => 1001.1,
                'parent_id' => null,
                'heading' => null,
                'title' => trans('webed-modules-management::base.admin_menu.plugins.title'),
                'font_icon' => 'icon-paper-plane',
                'link' => route('admin::plugins.index.get'),
                'css_class' => null,
                'permissions' => ['view-plugins'],
            ]);

        return $next($request);
    }
}
