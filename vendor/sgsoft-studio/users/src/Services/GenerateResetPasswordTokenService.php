<?php namespace WebEd\Base\Users\Services;

use WebEd\Base\Users\Repositories\Contracts\PasswordResetRepositoryContract;
use WebEd\Base\Users\Repositories\PasswordResetRepository;
use Carbon\Carbon;

class GenerateResetPasswordTokenService
{
    /**
     * @var PasswordResetRepository
     */
    protected $passwordResetRepository;

    /**
     * @param PasswordResetRepositoryContract $passwordResetRepository
     */
    public function __construct(PasswordResetRepositoryContract $passwordResetRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * @param string $email
     * @return bool|array
     */
    public function generate($email)
    {
        $passwordReset = $this->passwordResetRepository
            ->findWhere([
                'email' => $email,
            ]);

        $token = md5(config('app.name') . config('app.key') . 'password.reset' . $email . time());

        $expiredDateConfig = (int)config('webed-auth.front_actions.forgot_password.link_expired_after', 1) ?: 1;

        $expiredDate = Carbon::now()->addDay($expiredDateConfig);

        $data = [
            'email' => $email,
            'token' => $token,
            'expired_at' => $expiredDate->toDateTimeString(),
        ];

        $result = $this->passwordResetRepository
            ->createOrUpdatePasswordReset($passwordReset, $data);

        if ($result) {
            return $data;
        }

        return false;
    }
}
