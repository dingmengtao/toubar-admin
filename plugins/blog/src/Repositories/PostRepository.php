<?php namespace WebEd\Plugins\Blog\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;

class PostRepository extends EloquentBaseRepository implements PostRepositoryContract
{
    use EloquentUseSoftDeletes;

    /**
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createPost(array $data, array $categories = null, array $tags = null)
    {
        $result = $this->create($data);
        if ($result) {
            if ($categories !== null) {
                $this->syncCategories($result, $categories);
            }
            if ($tags !== null) {
                $this->syncTags($result, $tags);
            }
        }
        return $result;
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
        $result = $this->createOrUpdate($id, $data);
        if ($result) {
            if ($categories !== null) {
                $this->syncCategories($result, $categories);
            }
            if ($tags !== null) {
                $this->syncTags($result, $tags);
            }
        }
        return $result;
    }

    /**
     * @param int|null|Post $id
     * @param array $data
     * @return int
     */
    public function updatePost($id, array $data, array $categories = null, array $tags = null)
    {
        $result = $this->update($id, $data);
        if ($result) {
            if ($categories !== null) {
                $this->syncCategories($result, $categories);
            }
            if ($tags !== null) {
                $this->syncTags($result, $tags);
            }
        }
        return $result;
    }

    /**
     * @param int|Post|array $id
     * @param bool $force
     * @return bool
     */
    public function deletePost($id, $force = false)
    {
        return $this->delete($id, $force);
    }

    /**
     * @param Post|int $model
     * @param array $categories
     * @return bool|null
     */
    public function syncCategories($model, array $categories)
    {
        $model = $model instanceof Post ? $model : $this->find($model);

        try {
            $model->categories()->sync($categories);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param Post|int $model
     * @return array
     */
    public function getRelatedCategoryIds($model)
    {
        $model = $model instanceof Post ? $model : $this->find($model);

        try {
            return $model->categories()->allRelatedIds()->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param Post|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedCategories($model, array $params = [])
    {
        $model = $model instanceof Post ? $model : $this->find($model);

        $params = array_merge([
            'condition' => [
                webed_db_prefix() . 'status' => 1,
            ],
            'order_by' => [
                'order' => 'ASC',
                'created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => ['*'],
        ], $params);

        $this->model = $model->categories();

        return $this->advancedGet($params);
    }

    /**
     * @param Post|int $model
     * @param array $tags
     * @return bool|null
     */
    public function syncTags($model, array $tags)
    {
        $model = $model instanceof Post ? $model : $this->find($model);

        try {
            $model->tags()->sync($tags);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param Post|int $model
     * @return array
     */
    public function getRelatedTagIds($model)
    {
        $model = $model instanceof Post ? $model : $this->find($model);

        try {
            return $model->tags()->allRelatedIds()->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param Post|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedTags($model, array $params = [])
    {
        $model = $model instanceof Post ? $model : $this->find($model);

        $params = array_merge([
            'condition' => [
                'status' => 1,
            ],
            'order_by' => [
                'order' => 'ASC',
                'created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => ['*'],
        ], $params);

        $model = $model->tags()
            ->where($params['condition']);

        $model = $model->select($params['select']);

        foreach ($params['order_by'] as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }

        if ($params['take'] == 1) {
            return $model->first();
        }

        if ($params['take']) {
            return $model->take($params['take'])->get();
        }

        if ($params['paginate']['per_page']) {
            return $model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        }

        return $model->get();
    }

    /**
     * @param array|int $categoryId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getPostsByCategory($categoryId, array $params = [])
    {
        $params = array_merge([
            'condition' => [
                webed_db_prefix() . 'posts.status' => 1,
            ],
            'order_by' => [
                webed_db_prefix() . 'posts.order' => 'ASC',
                webed_db_prefix() . 'posts.created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => [
                webed_db_prefix() . 'posts.*',
            ],
            'with' => [

            ],
        ], $params);

        $this->model = $this->model
            ->leftJoin(webed_db_prefix() . 'posts_categories', webed_db_prefix() . 'posts.id', '=', webed_db_prefix() . 'posts_categories.post_id')
            ->where(function ($query) use ($categoryId) {
                return $query
                    ->whereIn(webed_db_prefix() . 'posts_categories.category_id', (array)$categoryId)
                    ->orWhereIn(webed_db_prefix() . 'posts.category_id', (array)$categoryId);
            })
            ->distinct();

        return $this->advancedGet($params);
    }

    /**
     * @param array|int $tagId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getPostsByTag($tagId, array $params = [])
    {
        $params = array_merge([
            'condition' => [
                webed_db_prefix() . 'posts.status' => 1,
            ],
            'order_by' => [
                webed_db_prefix() . 'posts.order' => 'ASC',
                webed_db_prefix() . 'posts.created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => [
                webed_db_prefix() . 'posts.*',
            ],
            'with' => [

            ],
        ], $params);

        $this->model = $this->model
            ->join(webed_db_prefix() . 'posts_tags', webed_db_prefix() . 'posts.id', '=', webed_db_prefix() . 'posts_tags.post_id')
            ->join(webed_db_prefix() . 'tags', webed_db_prefix() . 'tags.id', '=', webed_db_prefix() . 'posts_tags.tag_id')
            ->distinct();

        $params['condition'][] = [webed_db_prefix() . 'tags.id', 'IN', (array)$tagId];

        return $this->advancedGet($params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPosts(array $params)
    {
        return $this->advancedGet($params);
    }
}
