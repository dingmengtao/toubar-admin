<?php namespace WebEd\Plugins\Blog\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface BlogTagRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createBlogTag(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateBlogTag($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateBlogTag($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteBlogTag($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function getTags(array $params);
}
