<?php namespace WebEd\Plugins\Blog\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Base\Repositories\Traits\EloquentUseSoftDeletesCache;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;

class PostRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements PostRepositoryContract
{
    use EloquentUseSoftDeletesCache;

    /**
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createPost(array $data, array $categories = null, array $tags = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|Post $id
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createOrUpdatePost($id, array $data, array $categories = null, array $tags = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|Post $id
     * @param array $data
     * @return int
     */
    public function updatePost($id, array $data, array $categories = null, array $tags = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|Post|array $id
     * @param bool $force
     * @return bool
     */
    public function deletePost($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param Post|int $model
     * @param array $categories
     * @return bool|null
     */
    public function syncCategories($model, array $categories)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param Post|int $model
     * @return array
     */
    public function getRelatedCategoryIds($model)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param Post|int $model
     * @param array $tags
     * @return bool|null
     */
    public function syncTags($model, array $tags)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param Post|int $model
     * @return array
     */
    public function getRelatedTagIds($model)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array|int $categoryId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getPostsByCategory($categoryId, array $params = [])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array|int $tagId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getPostsByTag($tagId, array $params = [])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPosts(array $params)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param Post|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedTags($model, array $params = [])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param Post|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedCategories($model, array $params = [])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
