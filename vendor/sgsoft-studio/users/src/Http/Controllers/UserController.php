<?php namespace WebEd\Base\Users\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Users\Actions\CreateUserAction;
use WebEd\Base\Users\Actions\DeleteUserAction;
use WebEd\Base\Users\Actions\RestoreUserAction;
use WebEd\Base\Users\Actions\UpdateUserAction;
use WebEd\Base\Users\Http\DataTables\UsersListDataTable;
use WebEd\Base\Users\Http\Requests\CreateUserRequest;
use WebEd\Base\Users\Http\Requests\UpdateUserPasswordRequest;
use WebEd\Base\Users\Http\Requests\UpdateUserRequest;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class UserController extends BaseAdminController
{
    protected $module = WEBED_USERS;

    /**
     * @var \WebEd\Base\Users\Repositories\UserRepository
     */
    protected $repository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {
            $this->breadcrumbs->addLink(trans($this->module . '::base.users'), route('admin::users.index.get'));

            $this->getDashboardMenu($this->module);

            return $next($request);
        });

        $this->repository = $userRepository;
    }

    /**
     * @param UsersListDataTable $usersListDataTable
     * @return mixed
     */
    public function getIndex(UsersListDataTable $usersListDataTable)
    {
        $this->setPageTitle(trans($this->module . '::base.users'));

        $this->dis['dataTable'] = $usersListDataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_USERS, 'index.get', $usersListDataTable)->viewAdmin('index');
    }

    /**
     * Get data for DataTable
     * @param UsersListDataTable $usersListDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(UsersListDataTable $usersListDataTable)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $usersListDataTable, WEBED_USERS, 'index.post', $this);
    }

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateUserAction $action, $id, $status)
    {
        if ($id == get_current_logged_user_id()) {
            return response()->json(response_with_messages(
                trans('webed-users::base.cannot_update_status_yourself'),
                true,
                \Constants::FORBIDDEN_CODE
            ));
        }

        $result = $action->run($id, [
            'status' => $status
        ]);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $this->setPageTitle(trans($this->module . '::base.create_user'));
        $this->breadcrumbs->addLink(trans($this->module . '::base.create_user'));

        $this->dis['isLoggedInUser'] = false;
        $this->dis['isSuperAdmin'] = $this->loggedInUser->isSuperAdmin();

        $this->dis['object'] = $this->repository->getModel();

        $this->assets
            ->addStylesheets('bootstrap-datepicker')
            ->addJavascripts('bootstrap-datepicker')
            ->addJavascriptsDirectly('admin/modules/users/user-profiles/user-profiles.js')
            ->addStylesheetsDirectly('admin/modules/users/user-profiles/user-profiles.css');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_USERS, 'create.get')->viewAdmin('create');
    }

    /**
     * @param CreateUserRequest $request
     * @param CreateUserAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateUserRequest $request, CreateUserAction $action)
    {
        $data = $request->except([
            '_token', '_continue_edit', '_tab', 'roles',
        ]);

        if ($request->exists('birthday') && !$request->input('birthday')) {
            $data['birthday'] = null;
        }

        $result = $action->run($data);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($request->has('_continue_edit')) {
            return redirect()->to(route('admin::users.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::users.index.get'));
    }

    /**
     * @param RoleRepository $roleRepository
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getEdit(RoleRepositoryContract $roleRepository, $id)
    {
        $this->dis['isLoggedInUser'] = $this->loggedInUser->id == $id ? true : false;
        $this->dis['isSuperAdmin'] = $this->loggedInUser->isSuperAdmin();

        if ($this->loggedInUser->id !== $id) {
            if (!$this->repository->hasPermission($this->loggedInUser, ['edit-other-users'])) {
                abort(\Constants::FORBIDDEN_CODE);
            }
        }

        $item = $this->repository->find($id);

        if (!$item) {
            flash_messages()
                ->addMessages(trans($this->module . '::base.user_not_found'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $this->setPageTitle(trans($this->module . '::base.edit_user'), '#' . $id);
        $this->breadcrumbs->addLink(trans($this->module . '::base.edit_user'));

        $this->dis['object'] = $item;

        if (!$this->dis['isLoggedInUser'] && ($this->dis['isSuperAdmin'] || $this->loggedInUser->hasPermission(['assign-roles']))) {
            $roles = $roleRepository->get();

            $checkedRoles = $this->repository->getRelatedRoleIds($item);

            $resolvedRoles = [];
            foreach ($roles as $role) {
                $resolvedRoles[] = [
                    'roles[]', $role->id, $role->name, (in_array($role->id, $checkedRoles))
                ];
            }
            $this->dis['roles'] = $resolvedRoles;
        }

        $this->assets
            ->addStylesheets('bootstrap-datepicker')
            ->addJavascripts('bootstrap-datepicker')
            ->addJavascriptsDirectly('admin/modules/users/user-profiles/user-profiles.js')
            ->addStylesheetsDirectly('admin/modules/users/user-profiles/user-profiles.css');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_USERS, 'edit.get', $id)->viewAdmin('edit');
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateUserRequest $request, $id)
    {
        $data = $this->request->except([
            '_token', '_continue_edit', '_tab', 'username', 'email', 'roles',
        ]);

        if ($request->requestHasRoles()) {
            $roles = $request->input('roles');
        } else {
            if ($this->request->input('_tab') === 'roles') {
                $roles = [];
            }
        }
        if ($this->request->exists('birthday') && !$this->request->input('birthday')) {
            $data['birthday'] = null;
        }

        /**
         * Prevent current users edit their roles
         */
        $isLoggedInUser = (int)$this->loggedInUser->id === (int)$id ? true : false;
        if ($isLoggedInUser) {
            if ($this->request->exists('roles')) {
                $roles = null;
            }
        }

        if (!isset($roles)) {
            $roles = null;
        }

        return $this->updateUser($id, $data, $roles);
    }

    /**
     * @param UpdateUserPasswordRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdatePassword(UpdateUserPasswordRequest $request, $id)
    {
        return $this->updateUser($id, [
            'password' => $request->input('password'),
        ]);
    }

    /**
     * @param $id
     * @param array $data
     * @param array|null $roles
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateUser($id, array $data, $roles = null)
    {
        $action = app(UpdateUserAction::class);

        $result = $action->run($id, $data, $roles);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error'] || $this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::users.index.get'));
    }

    /**
     * @param DeleteUserAction $action
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteUserAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param DeleteUserAction $action
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteUserAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param RestoreUserAction $action
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreUserAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }
}
