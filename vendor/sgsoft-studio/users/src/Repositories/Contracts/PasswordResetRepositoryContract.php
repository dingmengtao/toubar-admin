<?php namespace WebEd\Base\Users\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface PasswordResetRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createPasswordReset(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdatePasswordReset($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updatePasswordReset($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deletePasswordReset($id, $force = false);

    /**
     * @param $token
     * @return BaseModelContract|mixed|null
     */
    public function getPasswordResetByToken($token);
}
