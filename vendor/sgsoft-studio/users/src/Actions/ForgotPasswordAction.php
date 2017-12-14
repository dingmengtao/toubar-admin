<?php namespace WebEd\Base\Users\Actions;

use WebEd\Base\Actions\AbstractAction;
use Illuminate\Http\Request;
use WebEd\Base\Users\Mails\ResetPasswordMail;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;
use WebEd\Base\Users\Services\GenerateResetPasswordTokenService;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordAction extends AbstractAction
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var GenerateResetPasswordTokenService
     */
    protected $generateTokenService;

    /**
     * @var ResetPasswordMail
     */
    protected $mail;

    public function __construct(
        UserRepositoryContract $userRepository,
        GenerateResetPasswordTokenService $service,
        ResetPasswordMail $mail
    )
    {
        $this->userRepository = $userRepository;

        $this->generateTokenService = $service;

        $this->mail = $mail;
    }

    public function run(Request $request)
    {
        $email = $request->input('email');

        $user = $this->userRepository->findWhere([
            'email' => $email,
        ]);

        if (!$user) {
            return $this->error('User not exists with this email');
        }

        $result = $this->generateTokenService->generate($email);

        if (!$result) {
            return $this->error('Some error occurred when generate token');
        }

        $data = [
            'username' => $user->username,
            'name' => $user->getUserName(),
            'email' => $email,
            'link' => route('front::auth.reset_password.get', [
                'token' => $result['token'],
            ]),
            'expired_at' => $result['expired_at'],
        ];

        Mail::to($email)->send($this->mail->with($data));

        return $this->success('Action completed', $data);
    }
}
