<?php namespace WebEd\Plugins\Miniprograms\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Miniprograms\Models\Investor;
use WebEd\Plugins\Miniprograms\Models\Item;
use WebEd\Plugins\Miniprograms\Models\Stage;
use WebEd\Plugins\Miniprograms\Models\Trade;
use WebEd\Plugins\Miniprograms\Models\WXTBUser;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\InvestorRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\UserRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\InvestorRepository;
use WebEd\Plugins\Miniprograms\Repositories\InvestorRepositoryCacheDecorator;
use WebEd\Plugins\Miniprograms\Repositories\ItemRepository;
use WebEd\Plugins\Miniprograms\Repositories\ItemRepositoryCacheDecorator;
use WebEd\Plugins\Miniprograms\Repositories\StageRepository;
use WebEd\Plugins\Miniprograms\Repositories\StageRepositoryCacheDecorator;
use WebEd\Plugins\Miniprograms\Repositories\TradeRepository;
use WebEd\Plugins\Miniprograms\Repositories\TradeRepositoryCacheDecorator;
use WebEd\Plugins\Miniprograms\Repositories\UserRepository;
use WebEd\Plugins\Miniprograms\Repositories\UserRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, function () {
            $repository = new UserRepository(new WXTBUser());
            if (config('webed-caching.repository.enabled')) {
                return new UserRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }
            return $repository;
        });

        $this->app->bind(InvestorRepositoryContract::class, function () {
            $repository = new InvestorRepository(new Investor());
            if (config('webed-caching.repository.enabled')) {
                return new InvestorRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }
            return $repository;
        });

        $this->app->bind(ItemRepositoryContract::class, function () {
            $repository = new ItemRepository(new Item());
            if (config('webed-caching.repository.enabled')) {
                return new ItemRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }
            return $repository;
        });

        $this->app->bind(StageRepositoryContract::class, function () {
            $repository = new StageRepository(new Stage());
            if (config('webed-caching.repository.enabled')) {
                return new StageRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }
            return $repository;
        });

        $this->app->bind(TradeRepositoryContract::class, function () {
            $repository = new TradeRepository(new Trade());
            if (config('webed-caching.repository.enabled')) {
                return new TradeRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }
            return $repository;
        });

    }
}
