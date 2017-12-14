<?php namespace WebEd\Base\Elfinder\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Elfinder\Hook\Actions\AddFileManagerUrlHook;
use WebEd\Base\Events\SessionStarted;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_action(BASE_ACTION_HEADER_JS, [AddFileManagerUrlHook::class, 'execute'], 3);

        Event::listen(SessionStarted::class, function () {
            $this->onSessionStarted();
        });
    }

    /**
     * Register dashboard menus, translations, cms settings
     */
    protected function onSessionStarted()
    {
        dashboard_menu()->registerItem([
            'id' => 'webed-elfinder',
            'priority' => 999.1,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-elfinder::base.admin_menu.title'),
            'font_icon' => 'icon-doc',
            'link' => route('admin::elfinder.index.get'),
            'css_class' => null,
            'permissions' => ['elfinder-view-files', 'elfinder-upload-files', 'elfinder-edit-files', 'elfinder-delete-files'],
        ]);
    }
}
