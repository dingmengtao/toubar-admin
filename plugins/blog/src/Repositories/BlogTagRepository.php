<?php namespace WebEd\Plugins\Blog\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;

class BlogTagRepository extends EloquentBaseRepository implements BlogTagRepositoryContract
{
    use EloquentUseSoftDeletes;

    /**
     * @param array $data
     * @return int
     */
    public function createBlogTag(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateBlogTag($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateBlogTag($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteBlogTag($id)
    {
        return $this->delete($id);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getTags(array $params)
    {
        return $this->advancedGet($params);
    }
}
