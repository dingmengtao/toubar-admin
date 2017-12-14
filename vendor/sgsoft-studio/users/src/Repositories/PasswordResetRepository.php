<?php namespace WebEd\Base\Users\Repositories;

use Carbon\Carbon;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Base\Users\Repositories\Contracts\PasswordResetRepositoryContract;

class PasswordResetRepository extends EloquentBaseRepository implements PasswordResetRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createPasswordReset(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdatePasswordReset($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updatePasswordReset($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deletePasswordReset($id, $force = false)
    {
        return $this->delete($id, $force);
    }

    /**
     * @param $token
     * @return \Illuminate\Database\Eloquent\Builder|mixed|null|\WebEd\Base\Models\EloquentBase
     */
    public function getPasswordResetByToken($token)
    {
        return $this->findWhere([
            'token' => $token,
            ['expired_at', '>=', Carbon::now()],
        ]);
    }
}
