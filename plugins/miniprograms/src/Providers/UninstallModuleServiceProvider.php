<?php namespace WebEd\Plugins\Miniprograms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class UninstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = WEBED_MINIPROGRAMS;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->unsetPermissionByModule($this->moduleAlias);

        $this->dropSchema();
    }

    protected function dropSchema()
    {
        Schema::dropIfExists(webed_db_prefix().'investor_trade');
        Schema::dropIfExists(webed_db_prefix().'item_trade');
        Schema::dropIfExists(webed_db_prefix().'investor');
        Schema::dropIfExists(webed_db_prefix().'item');
        Schema::dropIfExists(webed_db_prefix().'stage');
        Schema::dropIfExists(webed_db_prefix().'trade');
        Schema::dropIfExists(webed_db_prefix().'user');
    }
}
