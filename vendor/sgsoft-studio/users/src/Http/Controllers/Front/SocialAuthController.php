<?php namespace WebEd\Base\Users\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseController;
use Laravel\Socialite\Facades\Socialite;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class SocialAuthController extends BaseController
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        parent::__construct();

        $this->repository = $userRepository;
    }

    /**
     * @param string $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        switch ($provider) {
            case 'facebook':
                $user = Socialite::driver($provider)->fields([
                    'name',
                    'first_name',
                    'last_name',
                    'email',
                    'gender',
                    'verified',
                ])->user();
                $userData = [
                    'first_name' => $user->user['first_name'],
                    'last_name' => $user->user['last_name'],
                    'display_name' => $user->user['first_name'],
                    'email' => $user->getEmail(),
                    'avatar' => $user->getAvatar(),
                ];
                break;
            default:
                $user = Socialite::driver($provider)->user();
                $name = $user->getName();
                list($first_name, $last_name) = explode(' ', $name, 2);
                $userData = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'display_name' => $first_name,
                    'email' => $user->getEmail(),
                    'avatar' => $user->getAvatar(),
                ];
                break;
        }

        $userObj = $this->repository->findWhere(['email' => $userData['email']]);

        if ($userObj) {
            auth()->loginUsingId($userObj->id);
        } else {
            $password = str_random(8);

            $userId = $this->repository->createUser([
                'username' => $user->getEmail(),
                'first_name' => $userData['first_name'],
                'display_name' => $userData['display_name'],
                'last_name' => $userData['last_name'],
                'email' => $user->getEmail(),
                'password' => $password,
                'avatar' => $user->getAvatar(),
            ]);

            auth()->loginUsingId($userId);
        }

        return redirect()->to(asset(''));
    }
}
