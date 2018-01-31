<?php namespace WebEd\Plugins\Miniprograms\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Item\CreateItemAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Item\DeleteItemAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Item\RestoreItemAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Item\UpdateItemAction;
use WebEd\Plugins\Miniprograms\Http\DataTables\ItemDataTable;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Item\CreateItemRequest;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Item\UpdateItemRequest;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;

class ItemController extends BaseAdminController
{
    protected $module = WEBED_MINIPROGRAMS;

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(ItemRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_TOUBAR_ITEM);

            $this->breadcrumbs->addLink(WEBED_TOUBAR_ITEM, route('admin::miniprograms.toubar.item.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ItemDataTable $dataTables)
    {
        $this->setPageTitle('Item');

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_ITEM, 'index.get', $dataTables)->viewAdmin('toubar.item.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(ItemDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_TOUBAR_ITEM, 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateItemAction $action, $id, $status)
    {
        $result = $action->run($id, [
            'status' => $status
        ]);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate(TradeRepositoryContract $tradeRepository)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_ITEM, 'create.get');

        /**
         * Place your magic here
         */
        $allStages = get_stages();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allStages as $stage) {
            $selectArr[$stage->id] = $stage->name;
        }
        $this->dis['baseStages'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor',
                'jquery-select2'
            ])
            ->addStylesheets(['jquery-select2']);
        $this->dis['trades'] = $tradeRepository
            ->get(['id', 'name'])
            ->pluck('name', 'id')
            ->toArray();

        $this->setPageTitle('Create item');
        $this->breadcrumbs->addLink('Create item');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_ITEM, 'create.get')->viewAdmin('toubar.item.create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateItemRequest $request, CreateItemAction $action)
    {
        $data = $this->parseData($request);

        $result = $action->run($data, $request->input('trades', []));

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::miniprograms.toubar.item.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::miniprograms.toubar.item.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit(TradeRepositoryContract $tradeRepository, $id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_TOUBAR_ITEM, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $allStages = get_stages();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allStages as $stage) {
            $selectArr[$stage->id] = $stage->name;
        }
        $this->dis['baseStages'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor',
                'jquery-select2'
            ])
            ->addStylesheets(['jquery-select2']);
        $this->dis['trades'] = $tradeRepository
            ->get(['id', 'name'])
            ->pluck('name', 'id')
            ->toArray();
        $this->dis['selectedTrades'] = $this->repository->getRelatedTradeIds($item);

        $this->setPageTitle('Edit item' . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('Edit item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_ITEM, 'edit.get', $id)->viewAdmin('toubar.item.edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateItemRequest $request, UpdateItemAction $action, $id)
    {
        $data = $this->parseData($request);

        $result = $action->run($id, $data, $request->input('trades', []));

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error'] || $this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::miniprograms.toubar.item.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteItemAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteItemAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreItemAction $action, $id)
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
