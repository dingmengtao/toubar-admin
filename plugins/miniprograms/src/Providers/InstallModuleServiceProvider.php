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
//        acl_permission()
//            ->registerPermission('Permission 1 description', 'description-1', $this->moduleAlias)
//            ->registerPermission('Permission 2 description', 'description-2', $this->moduleAlias);
    }

    protected function createSchema()
    {
        Schema::create('investor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name','30');
            $table->string('company','300')->nullable();
            $table->string('job','300')->nullable();
            $table->string('telephone','50');
            $table->string('img_url','300')->nullable();
            $table->string('identify_one_url','300')->nullable();
            $table->string('identify_two_url','300')->nullable();
            $table->tinyInteger('isaudit')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
    }
}
