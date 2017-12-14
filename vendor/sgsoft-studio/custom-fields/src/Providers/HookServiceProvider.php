<?php namespace WebEd\Base\CustomFields\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\CustomFields\Hook\RenderCustomFields;
use WebEd\Base\CustomFields\Hook\StoreCustomFields;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        assets_management()->addJavascripts(['jquery-ckeditor']);

        add_action(BASE_ACTION_META_BOXES, [RenderCustomFields::class, 'handle'], 69);

        add_action(BASE_ACTION_AFTER_CREATE, [StoreCustomFields::class, 'handleCreate'], 69);
        add_action(BASE_ACTION_AFTER_UPDATE, [StoreCustomFields::class, 'handleUpdate'], 69);
    }
}
