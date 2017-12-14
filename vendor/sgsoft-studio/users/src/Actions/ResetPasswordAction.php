<?php namespace WebEd\Base\Users\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Users\Repositories\Contracts\PasswordResetRepositoryContract;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\PasswordResetRepository;
use WebEd\Base\Users\Repositories\UserRepository;

class ResetPasswordAction extends AbstractAction
{
    /**
     * @var PasswordResetRepository
     */
    protected $passwordResetRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(
        PasswordResetRepositoryContract $passwordResetRepository,
        UserRepositoryContract $userRepository
    )
    {
        $this->passwordResetRepository = $passwordResetRepository;

        $this->userRepository = $userRepository;
    }

    /**
     * @param string $token
     * @param string $password: Non hashed string
     * @return array
     */
    public function run($token, $password)
    {
        $passwordReset = $this->passwordResetRepository
            ->getPasswordResetByToken($token);

        if (!$passwordReset) {
            return $this->error('User not exists');
        }

        $user = $this->userRepository
            ->findWhere([
                'email' => $passwordReset->email,
            ]);

        if (!$user) {
            return $this->error('User not exists');
        }

        $result = $this->userRepository
            ->updateUser($user, [
                'password' => $password
            ]);

        if (!$result) {
            return $this->error('Error occurred when update user');
        }

        $this->passwordResetRepository->delete($passwordReset);

        return $this->success('Your password has been reset', [
            'user_id' => $result
        ]);
    }
}
