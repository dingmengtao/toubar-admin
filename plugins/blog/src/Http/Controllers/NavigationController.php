<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Blog\Actions\Navigation\CreateNavigationAction;
use WebEd\Plugins\Blog\Actions\Navigation\DeleteNavigationAction;
use WebEd\Plugins\Blog\Actions\Navigation\UpdateNavigationAction;
use WebEd\Plugins\Blog\Http\DataTables\NavigationDataTable;
use WebEd\Plugins\Blog\Http\Requests\UpdateNavigationRequest;
use WebEd\Plugins\Blog\Repositories\Contracts\NavigationRepositoryContract;
use WebEd\Plugins\Blog\Repositories\NavigationRepository;
use WebEd\Plugins\Blog\Http\Requests\CreateNavigationRequest;

class NavigationController extends BaseAdminController
{
    protected $module = WEBED_BLOG;

    /**
     * @var NavigationRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param NavigationRepositoryContract $repository
     */
    public function __construct(NavigationRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink('webed-blog', route('admin::navigation.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(NavigationDataTable $dataTables)
    {
        $this->setPageTitle('导航设置');

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, 'webed-blog', 'index.get', $dataTables)->viewAdmin('navigation.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(NavigationDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, 'webed-blog', 'index.post', $this);
    }

    /**
     * @param UpdateNavigationAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateNavigationAction $action, $id, $status)
    {
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_POSTS, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create Navigation');
        $this->breadcrumbs->addLink('Create Navigation');

        return do_filter(BASE_FILTER_CONTROLLER, $this,WEBED_BLOG_POSTS, 'create.get')->viewAdmin('navigation.create');
    }

    /**
     * @param CreateNavigationRequest $request
     * @param CreateNavigationAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateNavigationRequest $request, CreateNavigationAction $action)
    {
        $data = $this->parseData($request);


        $result = $action->run($data);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::blog.navigation.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::navigation.index.get'));
    }
//
//    /**
//     * @param int $id
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
//     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_NAVIGATION, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->dis['object'] = $item;//赋值对象
        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_NAVIGATION, 'edit.get', $id)->viewAdmin('navigation.edit');
    }

    /**
     * @param UpdateNavigationRequest $request
     * @param UpdateNavigationAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateNavigationRequest $request, UpdateNavigationAction $action, $id)
    {
        $data = $this->parseData($request);

        $result = $action->run($id, $data);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error'] || $this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::navigation.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteNavigationAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

//    /**
//     * @param $id
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function postForceDelete(YourDeleteEntityAction $action, $id)
//    {
//        $result = $action->run($id, true);
//
//        return response()->json($result, $result['response_code']);
//    }
//
//    /**
//     * @param $id
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function postRestore(YourRestoreEntityAction $action, $id)
//    {
//        $result = $action->run($id);
//
//        return response()->json($result, $result['response_code']);
//    }

    protected function parseData(\WebEd\Base\Http\Requests\Request $request)
    {
        $data = $request->input('page');

        return $data;
    }
}
