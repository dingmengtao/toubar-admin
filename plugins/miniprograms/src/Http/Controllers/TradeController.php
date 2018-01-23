<?php namespace WebEd\Plugins\Miniprograms\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Trade\CreateTradeAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Trade\DeleteTradeAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Trade\RestoreTradeAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Trade\UpdateTradeAction;
use WebEd\Plugins\Miniprograms\Http\DataTables\TradeDataTable;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Trade\CreateTradeRequest;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Trade\UpdateTradeRequest;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;

class TradeController extends BaseAdminController
{
    protected $module = WEBED_MINIPROGRAMS;

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(TradeRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_TOUBAR_TRADE);

            $this->breadcrumbs->addLink(WEBED_TOUBAR_TRADE, route('admin::miniprograms.toubar.trade.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(TradeDataTable $dataTables)
    {
        $this->setPageTitle('Trade');

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_TRADE, 'index.get', $dataTables)->viewAdmin('toubar.trade.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(TradeDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_TOUBAR_TRADE, 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateTradeAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_TRADE, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create trade');
        $this->breadcrumbs->addLink('Create trade');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_TRADE, 'create.get')->viewAdmin('toubar.trade.create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateTradeRequest $request, CreateTradeAction $action)
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
            return redirect()->to(route('admin::miniprograms.toubar.trade.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::miniprograms.toubar.trade.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_TOUBAR_TRADE, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->setPageTitle('Edit trade' . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('Edit trade'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_TRADE, 'edit.get', $id)->viewAdmin('toubar.trade.edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateTradeRequest $request, UpdateTradeAction $action, $id)
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

        return redirect()->to(route('admin::miniprograms.toubar.trade.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteTradeAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteTradeAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreTradeAction $action, $id)
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
