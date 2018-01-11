<?php namespace WebEd\Plugins\Share\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Share\Actions\CreateShareAction;
use WebEd\Plugins\Share\Actions\DeleteShareAction;
use WebEd\Plugins\Share\Actions\RestoreShareAction;
use WebEd\Plugins\Share\Actions\UpdateShareAction;
use WebEd\Plugins\Share\Http\DataTables\ShareDataTable;
use WebEd\Plugins\Share\Http\DataTables\ShareListDataTable;
use WebEd\Plugins\Share\Http\Requests\CreateShareRequest;
use WebEd\Plugins\Share\Http\Requests\UpdateShareRequest;
use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;

class ShareController extends BaseAdminController
{
    protected $module = 'share';

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(ShareRepositoryContract $shareRepository)
    {
        parent::__construct();

        $this->repository = $shareRepository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink('share', route('admin::share.share.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ShareListDataTable $dataTables)
    {
        $this->setPageTitle('Share');
//        $this->getDashboardMenu($this->module);
        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_SHARE, 'index.get', $dataTables)->viewAdmin('share.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(ShareListDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_SHARE, 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateShareAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_SHARE, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create Share');
        $this->breadcrumbs->addLink('Create Share');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_SHARE, 'create.get')->viewAdmin('share.create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateShareRequest $request, CreateShareAction $action)
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
            return redirect()->to(route('admin::share.share.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::share.share.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_SHARE, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->setPageTitle('Edit share' . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('Edit share'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_SHARE, 'edit.get', $id)->viewAdmin('share.edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateShareRequest $request, UpdateShareAction $action, $id)
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

        return redirect()->to(route('admin::share.share.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteShareAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteShareAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreShareAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    protected function parseData(\WebEd\Base\Http\Requests\Request $request)
    {
        $data = $request->input('post');

        return $data;
    }
}
