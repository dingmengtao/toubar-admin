<?php namespace WebEd\Plugins\Share\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'share';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->createSchema();
//        acl_permission()
//            ->registerPermission('Permission 1 description', 'description-1', $this->moduleAlias)
//            ->registerPermission('Permission 2 description', 'description-2', $this->moduleAlias);
    }

    protected function createSchema()
    {
        Schema::create(webed_db_prefix().'share', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('link_url');
//            $table->string('icon_url');
            $table->string('thumbnail')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_featured')->default(0);
            $table->integer('order')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
    }
}
