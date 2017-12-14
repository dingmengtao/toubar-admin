<?php namespace WebEd\Base\CustomFields\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\CustomFields\Repositories\Contracts\CustomFieldRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldItemRepositoryContract;
use WebEd\Base\CustomFields\Repositories\CustomFieldRepository;
use WebEd\Base\CustomFields\Repositories\CustomFieldRepositoryCacheDecorator;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;
use WebEd\Base\CustomFields\Repositories\FieldItemRepository;
use WebEd\Base\CustomFields\Models\CustomField;
use WebEd\Base\CustomFields\Models\FieldGroup;
use WebEd\Base\CustomFields\Models\FieldItem;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FieldGroupRepositoryContract::class, function () {
            return new FieldGroupRepository(new FieldGroup());
        });
        $this->app->bind(FieldItemRepositoryContract::class, function () {
            return new FieldItemRepository(new FieldItem());
        });
        $this->app->bind(CustomFieldRepositoryContract::class, function () {
            $repository = new CustomFieldRepository(new CustomField());

            if (config('webed-caching.repository.enabled')) {
                return new CustomFieldRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
