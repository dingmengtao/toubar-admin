<?php namespace WebEd\Plugins\Miniprograms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = WEBED_MINIPROGRAMS;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->createSchema();
        acl_permission()
            ->registerPermission('View user', 'view-user', $this->moduleAlias)
            ->registerPermission('Create user', 'create-user', $this->moduleAlias)
            ->registerPermission('Update user', 'update-user', $this->moduleAlias)
            ->registerPermission('Delete user', 'delete-user', $this->moduleAlias)
            ->registerPermission('Restore deleted user', 'restore-deleted-user', $this->moduleAlias)
            ->registerPermission('Delete user permanently', 'force-delete-user', $this->moduleAlias)

            ->registerPermission('View stage', 'view-stage', $this->moduleAlias)
            ->registerPermission('Create stage', 'create-stage', $this->moduleAlias)
            ->registerPermission('Update stage', 'update-stage', $this->moduleAlias)
            ->registerPermission('Delete stage', 'delete-stage', $this->moduleAlias)
            ->registerPermission('Restore deleted stage', 'restore-deleted-stage', $this->moduleAlias)
            ->registerPermission('Delete stage permanently', 'force-delete-stage', $this->moduleAlias)

            ->registerPermission('View trade', 'view-trade', $this->moduleAlias)
            ->registerPermission('Create trade', 'create-trade', $this->moduleAlias)
            ->registerPermission('Update trade', 'update-trade', $this->moduleAlias)
            ->registerPermission('Delete trade', 'delete-trade', $this->moduleAlias)
            ->registerPermission('Restore deleted trade', 'restore-deleted-trade', $this->moduleAlias)
            ->registerPermission('Delete trade permanently', 'force-delete-trade', $this->moduleAlias)

            ->registerPermission('View investor', 'view-investor', $this->moduleAlias)
            ->registerPermission('Create investor', 'create-investor', $this->moduleAlias)
            ->registerPermission('Update investor', 'update-investor', $this->moduleAlias)
            ->registerPermission('Delete investor', 'delete-investor', $this->moduleAlias)
            ->registerPermission('Restore deleted investor', 'restore-deleted-investor', $this->moduleAlias)
            ->registerPermission('Delete investor permanently', 'force-delete-investor', $this->moduleAlias)

            ->registerPermission('View item', 'view-item', $this->moduleAlias)
            ->registerPermission('Create item', 'create-item', $this->moduleAlias)
            ->registerPermission('Update item', 'update-item', $this->moduleAlias)
            ->registerPermission('Delete item', 'delete-item', $this->moduleAlias)
            ->registerPermission('Restore deleted item', 'restore-deleted-item', $this->moduleAlias)
            ->registerPermission('Delete item permanently', 'force-delete-item', $this->moduleAlias);
    }

    protected function createSchema()
    {
        /**
         * Create table user
         */
        Schema::create(webed_db_prefix().'user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('openid','50');
            $table->string('nickname','100')->nullable();
            $table->string('country','50')->nullable();
            $table->string('province','50')->nullable();
            $table->string('city','100')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('language','50')->nullable();
            $table->string('extend','255')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
        /**
         * Create table stage
         */
        Schema::create(webed_db_prefix().'stage', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name','50');
            $table->tinyInteger('status')->default(1);
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
        /**
         * Create table trade
         */
        Schema::create(webed_db_prefix().'trade', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name','50');
            $table->tinyInteger('status')->default(1);
            $table->string('type','50')->default('circle');
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
        /**
         * Create table investor
         */
        Schema::create(webed_db_prefix().'investor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name','300');
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
            $table->foreign('user_id')->references('id')->on(webed_db_prefix().'user');
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
        /**
         * Create table item
         */
        Schema::create(webed_db_prefix().'item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name','300');
            $table->integer('stage_id')->unsigned();
            $table->string('telephone','50');
            $table->string('bp_url','300');
            $table->string('video_url','300')->nullable();
            $table->string('img_url','300')->nullable();
            $table->tinyInteger('isgood')->default(0);
            $table->tinyInteger('isaudit')->default(0);
            $table->tinyInteger('type')->default(2);
            $table->tinyInteger('status')->default(0);
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on(webed_db_prefix().'user');
            $table->foreign('stage_id')->references('id')->on(webed_db_prefix().'stage');
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
        /**
         * Create table investor_trade
         */
        Schema::create(webed_db_prefix().'investor_trade', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('investor_id')->unsigned();
            $table->integer('trade_id')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['investor_id','trade_id']);
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
        /**
         * Create table item_trade
         */
        Schema::create(webed_db_prefix().'item_trade', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('item_id')->unsigned();
            $table->integer('trade_id')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->integer('order')->default(0);
            $table->integer('delete_time')->nullable();
            $table->integer('create_time')->nullable();
            $table->integer('update_time')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['item_id','trade_id']);
            $table->foreign('created_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on(webed_db_prefix() . 'users')->onDelete('set null');
        });
    }
}
