<?php namespace WebEd\Plugins\Blog\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface NewsRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createNews(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateNews($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateNews($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteNews($id, $force = false);
}
