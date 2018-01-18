<?php namespace WebEd\Plugins\Blog\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Plugins\Blog\Repositories\Contracts\NewsRepositoryContract;

class NewsRepository extends EloquentBaseRepository implements NewsRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createNews(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateNews($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateNews($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteNews($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
