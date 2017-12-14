<?php namespace WebEd\Base\Users\Http\Controllers\Front;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use WebEd\Base\Http\Controllers\BaseFrontController;
use WebEd\Base\Users\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends BaseFrontController
{
    use SendsPasswordResetEmails;

    /**
     * @return mixed
     */
    public function broker()
    {
        return Password::broker('webed-users');
    }

    public function getIndex()
    {
        $this->setBodyClass('forgot-password-page');
        $this->setPageTitle(trans('webed-users::auth.forgot_password'));

        return $this->view(config('webed-auth.front_actions.forgot_password.view') ?: 'webed-users::front.auth.forgot-password');
    }

    public function postIndex(ForgotPasswordRequest $request)
    {
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response != Password::RESET_LINK_SENT) {
            flash_messages()
                ->addMessages(trans($response), 'error')
                ->showMessagesOnSession();
            return redirect()->back();
        }

        flash_messages()
            ->addMessages(trans($response), 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('front.web.resolve-pages.get'));
    }
}
