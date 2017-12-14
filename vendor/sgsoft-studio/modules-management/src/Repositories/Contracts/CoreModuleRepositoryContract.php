<?php namespace WebEd\Base\ModulesManagement\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface CoreModuleRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createCoreModules(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateCoreModules($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateCoreModules($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteCoreModules($id);
}
