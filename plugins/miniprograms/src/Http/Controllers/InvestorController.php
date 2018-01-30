<?php namespace WebEd\Plugins\Miniprograms\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Investor\CreateInvestorAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Investor\DeleteInvestorAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Investor\RestoreInvestorAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Investor\UpdateInvestorAction;
use WebEd\Plugins\Miniprograms\Http\DataTables\InvestorDataTable;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Investor\CreateInvestorRequest;
use WebEd\Plugins\Miniprograms\Http\Requests\Toubar\Investor\UpdateInvestorRequest;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\InvestorRepositoryContract;

class InvestorController extends BaseAdminController
{
    protected $module = WEBED_MINIPROGRAMS;

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(InvestorRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_TOUBAR_INVESTOR);

            $this->breadcrumbs->addLink(WEBED_TOUBAR_INVESTOR, route('admin::miniprograms.toubar.investor.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(InvestorDataTable $dataTables)
    {
        $this->setPageTitle('Investor');

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_INVESTOR, 'index.get', $dataTables)->viewAdmin('toubar.investor.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(InvestorDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_TOUBAR_INVESTOR, 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateInvestorAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_INVESTOR, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create investor');
        $this->breadcrumbs->addLink('Create investor');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_INVESTOR, 'create.get')->viewAdmin('toubar.investor.create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateInvestorRequest $request, CreateInvestorAction $action)
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
            return redirect()->to(route('admin::miniprograms.toubar.investor.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::miniprograms.toubar.investor.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_TOUBAR_INVESTOR, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->setPageTitle('Edit investor' . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('Edit investor'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_TOUBAR_INVESTOR, 'edit.get', $id)->viewAdmin('toubar.investor.edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateInvestorRequest $request, UpdateInvestorAction $action, $id)
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

        return redirect()->to(route('admin::miniprograms.toubar.investor.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteInvestorAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteInvestorAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreInvestorAction $action, $id)
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
