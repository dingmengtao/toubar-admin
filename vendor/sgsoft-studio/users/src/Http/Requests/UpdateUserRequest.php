<?php namespace WebEd\Base\Users\Http\Requests;

use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\Http\Requests\Request;
use WebEd\Base\Users\Models\User;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class UpdateUserRequest extends Request
{
    public function rules()
    {
        return [
            'display_name' => 'string|between:1,150|nullable',
            'first_name' => 'string|between:1,100|nullable',
            'last_name' => 'string|between:1,100|nullable',
            'avatar' => 'string|between:1,255|nullable',
            'phone' => 'string|max:20|nullable',
            'mobile_phone' => 'string|max:20|nullable',
            'sex' => 'string|nullable|in:male,female,other',
            'birthday' => 'date_multi_format:Y-m-d H:i:s,Y-m-d|nullable',
            'description' => 'string|max:1000|nullable',
        ];
    }

    /**
     * @var array
     */
    protected $roles = [];

    /**
     * @var User
     */
    protected $loggedInUser;

    /**
     * @return bool
     */
    public function requestHasRoles()
    {
        if ($this->exists('roles')) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getSuperAdminRole()
    {
        /**
         * @var RoleRepository $repo
         */
        $repo = app(RoleRepositoryContract::class);
        $role = $repo
            ->withCache(false)
            ->where('slug', '=', 'super-admin')->first();
        if (!$role) {
            return [];
        }
        return [$role->id];
    }

    /**
     * @return array
     */
    public function getResolvedRoles()
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        if (!$this->requestHasRoles()) {
            return true;
        }

        $this->roles = $this->get('roles');

        /**
         * @var User $loggedInUser
         */
        $loggedInUser = $this->user();

        if (!$loggedInUser->isSuperAdmin()) {
            if (!$loggedInUser->hasPermission('assign-roles')) {
                return false;
            }
            /**
             * Only super admin can assign super admin
             */
            $this->roles = array_diff($this->roles, $this->getSuperAdminRole());
            return true;
        }

        /**
         * Is super admin
         */
        return true;
    }
}
