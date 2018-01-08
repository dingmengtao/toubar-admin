<?php
namespace WebEd\Plugins\Banner\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Banner\Repositories\BannerRepository;
use WebEd\Plugins\Banner\Repositories\Contracts\BannerRepositoryContract;
use WebEd\Plugins\Banner\Http\DataTables\BannerDataTable;


class IndexController extends BaseAdminController
{
    protected $module = 'banner';

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        parent::__construct();

        $this->repository = $bannerRepository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink('banner', route('admin::banner.index.get'));//应该是生成导航地址

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(BannerDataTable $dataTables)
    {
        $this->setPageTitle('Entity');
        $this->getDashboardMenu($this->module);
        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, 'banner', 'index.get', $dataTables)->view('index');
//        return $this->view('index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(YourDataTables $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, 'banner', 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(YourUpdateEntityAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, YOUR_SCREEN_NAME, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create entity');
        $this->breadcrumbs->addLink('Create entity');

        return do_filter(BASE_FILTER_CONTROLLER, $this, YOUR_SCREEN_NAME, 'create.get')->viewAdmin('create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(YourCreateEntityRequest $request, YourCreateEntityAction $action)
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
            return redirect()->to(route('admin::your-module.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::your-module.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, YOUR_SCREEN_NAME, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */

        return do_filter(BASE_FILTER_CONTROLLER, $this, YOUR_SCREEN_NAME, 'edit.get', $id)->viewAdmin('edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(YourUpdateEntityRequest $request, YourUpdateEntityAction $action, $id)
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

        return redirect()->to(route('admin::your-module.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(YourDeleteEntityAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(YourDeleteEntityAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(YourRestoreEntityAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    protected function parseData(\WebEd\Base\Http\Requests\Request $request)
    {
        $data = $request->input('entity');

        return $data;
    }
    public function a(){
        echo 2;
    }
}
