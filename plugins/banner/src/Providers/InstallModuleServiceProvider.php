<?php namespace WebEd\Plugins\Banner\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'banner';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->createSchema();//创建数据表
        acl_permission()
            ->registerPermission('修改首页banner', 'banner', $this->moduleAlias);//创建新权限

    }

    protected function createSchema()
    {//构造banner数据表
        Schema::create(webed_db_prefix() .'banner', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('path', 255)->nullable();
        });
    }
}
