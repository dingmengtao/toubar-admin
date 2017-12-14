<?php namespace WebEd\Base\ModulesManagement\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\ModulesManagement\Repositories\Contracts\CoreModuleRepositoryContract;

class CoreModuleRepository extends EloquentBaseRepository implements CoreModuleRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createCoreModules(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateCoreModules($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateCoreModules($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteCoreModules($id)
    {
        return $this->delete($id);
    }
}
