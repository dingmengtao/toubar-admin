<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface StageRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createStage(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateStage($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateStage($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteStage($id, $force = false);
}
