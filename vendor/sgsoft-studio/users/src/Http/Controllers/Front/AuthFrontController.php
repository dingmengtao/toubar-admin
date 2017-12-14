<?php namespace WebEd\Base\Users\Http\Controllers\Front;

use WebEd\Base\Users\Http\Requests\AuthFrontRequest;
use WebEd\Base\Http\Controllers\BaseController;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Support\Traits\Auth;
use Illuminate\Support\Facades\Auth as AuthFacade;

class AuthFrontController extends BaseController
{
    use Auth;

    /**
     * @var string
     */
    public $loginPath = 'auth';

    /**
     * @var string
     */
    public $redirectTo;

    /**
     * @var string
     */
    public $redirectPath;

    /**
     * @var string
     */
    public $redirectToLoginPage;

    /**
     * AuthController constructor.
     * @param \WebEd\Base\Users\Repositories\UserRepository $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        parent::__construct();

        $this->repository = $userRepository;

        $this->redirectTo = $this->request->input('redirect') ? asset($this->request->input('redirect')) : asset('');
        $this->redirectPath = $this->request->input('redirect') ? asset($this->request->input('redirect')) : asset('');
        $this->redirectToLoginPage = route('front::auth.login.get');
    }

    /**
     * Show login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $this->setBodyClass('login-page');
        $this->setPageTitle(trans('webed-users::auth.sign_in'));

        return $this->view(config('webed-auth.front_actions.login.view') ?: 'webed-users::front.auth.login');
    }

    /**
     * @param AuthFrontRequest $authRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function postLogin(AuthFrontRequest $authRequest)
    {
        return $this->login($authRequest);
    }

    /**
     * Logout and redirect to login page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->guard()->logout();

        return redirect()->to($this->redirectToLoginPage);
    }

    /**
     * @return array|null|string
     */
    protected function getFailedLoginMessage()
    {
        $failedMessage = 'webed-users::auth.failed';

        return lang()->has($failedMessage)
            ? lang()->get($failedMessage)
            : 'These credentials do not match our records!!!';
    }

    protected function guard()
    {
        return AuthFacade::guard(config('webed-auth.front_actions.guard'));
    }
}
