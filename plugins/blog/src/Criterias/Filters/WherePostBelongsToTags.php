<?php namespace WebEd\Plugins\Blog\Criterias\Filters;

use Illuminate\Database\Eloquent\Builder;
use WebEd\Base\Criterias\AbstractCriteria;
use WebEd\Base\Repositories\AbstractBaseRepository;
use WebEd\Base\Repositories\Contracts\AbstractRepositoryContract;
use WebEd\Plugins\Blog\Models\Post;

class WherePostBelongsToTags extends AbstractCriteria
{
    /**
     * @var array
     */
    protected $tagIds;

    public function __construct(array $tagIds)
    {
        $this->tagIds = $tagIds;
    }

     /**
      * @param Post|Builder $model
      * @param AbstractBaseRepository $repository
      * @return mixed
      */
    public function apply($model, AbstractRepositoryContract $repository)
    {
        return $model->join(webed_db_prefix() . 'posts_tags', webed_db_prefix() . 'posts.id', '=', webed_db_prefix() . 'posts_tags.post_id')
            ->join(webed_db_prefix() . 'tags', webed_db_prefix() . 'tags.id', '=', webed_db_prefix() . 'posts_tags.tag_id')
            ->whereIn(webed_db_prefix() . 'tags.id', $this->tagIds)
            ->distinct();
    }
}
