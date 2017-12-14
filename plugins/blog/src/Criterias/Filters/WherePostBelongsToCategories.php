<?php namespace WebEd\Plugins\Blog\Criterias\Filters;

use Illuminate\Database\Eloquent\Builder;
use WebEd\Base\Criterias\AbstractCriteria;
use WebEd\Base\Repositories\AbstractBaseRepository;
use WebEd\Base\Repositories\Contracts\AbstractRepositoryContract;
use WebEd\Plugins\Blog\Models\Post;

class WherePostBelongsToCategories extends AbstractCriteria
{
    /**
     * @var array
     */
    protected $categoryIds;

    public function __construct(array $categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }

     /**
      * @param Post|Builder $model
      * @param AbstractBaseRepository $repository
      * @return mixed
      */
    public function apply($model, AbstractRepositoryContract $repository)
    {
        return $model->leftJoin(webed_db_prefix() . 'posts_categories', webed_db_prefix() . 'posts.id', '=', webed_db_prefix() . 'posts_categories.post_id')
            ->leftJoin(webed_db_prefix() . 'categories', webed_db_prefix() . 'categories.id', '=', webed_db_prefix() . 'posts_categories.category_id')
            ->leftJoin(webed_db_prefix() . 'categories as base_category', webed_db_prefix() . 'categories.id', '=', webed_db_prefix() . 'posts.category_id')
            ->whereIn(webed_db_prefix() . 'categories.id', $this->categoryIds)
            ->distinct();
    }
}
