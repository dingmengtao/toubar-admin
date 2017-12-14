<?php namespace WebEd\Base\CustomFields\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
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
        Event::listen(SessionStarted::class, function () {
            $this->onSessionStarted();
        });
    }

    /**
     * Register dashboard menus, translations, cms settings
     */
    protected function onSessionStarted()
    {
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-custom-fields',
            'priority' => 999.3,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-custom-fields::base.admin_menu.title'),
            'font_icon' => 'icon-briefcase',
            'link' => route('admin::custom-fields.index.get'),
            'css_class' => null,
            'permissions' => ['view-custom-fields'],
        ]);

        $this->registerUsersFields();
    }

    protected function registerUsersFields()
    {
        CustomFieldSupportFacade::registerRule('other', trans('webed-custom-fields::rules.logged_in_user'), 'logged_in_user', function () {
            $userRepository = app(\WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract::class);

            $users = $userRepository->get();

            $userArr = [];
            foreach ($users as $user) {
                $userArr[$user->id] = $user->username . ' - ' . $user->email;
            }

            return $userArr;
        })
            ->registerRule('other', trans('webed-custom-fields::rules.logged_in_user_has_role'), 'logged_in_user_has_role', function () {
                $repository = app(\WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract::class);

                $roles = $repository->get(['id', 'name', 'slug']);

                $rolesArr = [];
                foreach ($roles as $role) {
                    $rolesArr[$role->slug] = $role->name . ' - (' . $role->slug . ')';
                }

                return $rolesArr;
            });
    }
}
