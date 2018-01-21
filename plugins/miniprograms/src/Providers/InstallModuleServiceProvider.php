<?php namespace WebEd\Plugins\Miniprograms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'miniprograms';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->createSchema();
        acl_permission()
            ->registerPermission('Permission 1 description', 'description-1', $this->moduleAlias)
            ->registerPermission('Permission 2 description', 'description-2', $this->moduleAlias);
    }

    protected function createSchema()
    {
        Schema::create('table-name', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
    }
}
