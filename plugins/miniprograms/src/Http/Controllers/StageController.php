<?php namespace WebEd\Plugins\Miniprograms\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Stage\CreateStageAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Stage\DeleteStageAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Stage\RestoreStageAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Stage\UpdateStageAction;
use WebEd\Plugins\Miniprograms\Http\DataTables\StageDataTable;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Stage\CreateStageRequest;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Stage\UpdateStageRequest;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;

class StageController extends BaseAdminController
{
    protected $module = WEBED_MINIPROGRAMS;

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(StageRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_TOUBAR_STAGE);

            $this->breadcrumbs->addLink(WEBED_TOUBAR_STAGE, route('admin::miniprograms.toubar.stage.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(StageDataTable $dataTables)
    {
        // 浏览器图标或名称
        $this->setPageTitle('Stage');

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_STAGE, 'index.get', $dataTables)->viewAdmin('toubar.stage.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(StageDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_TOUBAR_STAGE, 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateStageAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_STAGE, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create stage');
        $this->breadcrumbs->addLink('Create stage');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_STAGE, 'create.get')->viewAdmin('toubar.stage.create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateStageRequest $request, CreateStageAction $action)
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
            return redirect()->to(route('admin::miniprograms.toubar.stage.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::miniprograms.toubar.stage.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_TOUBAR_STAGE, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->setPageTitle('Edit stage' . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('Edit tage'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_STAGE, 'edit.get', $id)->viewAdmin('toubar.stage.edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateStageRequest $request, UpdateStageAction $action, $id)
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

        return redirect()->to(route('admin::miniprograms.toubar.stage.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteStageAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteStageAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreStageAction $action, $id)
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
