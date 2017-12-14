<?php namespace WebEd\Base\StaticBlocks\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\StaticBlocks\Actions\CreateStaticBlockAction;
use WebEd\Base\StaticBlocks\Actions\DeleteStaticBlockAction;
use WebEd\Base\StaticBlocks\Actions\UpdateStaticBlockAction;
use WebEd\Base\StaticBlocks\Http\DataTables\StaticBlockDataTable;
use WebEd\Base\StaticBlocks\Http\Requests\CreateStaticBlockRequest;
use WebEd\Base\StaticBlocks\Http\Requests\UpdateStaticBlockRequest;
use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepository;

class StaticBlockController extends BaseAdminController
{
    protected $module = WEBED_STATIC_BLOCKS;

    /**
     * @var StaticBlockRepository|EloquentBaseRepository
     */
    protected $repository;

    public function __construct(StaticBlockRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink(trans($this->module . '::base.page_title'), route('admin::static-blocks.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(StaticBlockDataTable $dataTables)
    {
        $this->setPageTitle(trans($this->module . '::base.page_title'));

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_STATIC_BLOCKS, 'index.get', $dataTables)->viewAdmin('index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(StaticBlockDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_STATIC_BLOCKS, 'index.post', $this);
    }

    /**
     * @param UpdateStaticBlockAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateStaticBlockAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_STATIC_BLOCKS, 'create.get');

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans($this->module . '::base.form.create'));
        $this->breadcrumbs->addLink(trans($this->module . '::base.form.create'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_STATIC_BLOCKS, 'create.get')->viewAdmin('create');
    }

    /**
     * @param CreateStaticBlockRequest $request
     * @param CreateStaticBlockAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateStaticBlockRequest $request, CreateStaticBlockAction $action)
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
            return redirect()->to(route('admin::static-blocks.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::static-blocks.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_STATIC_BLOCKS, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans($this->module . '::base.form.edit_item') . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans($this->module . '::base.form.edit_item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_STATIC_BLOCKS, 'edit.get', $id)->viewAdmin('edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateStaticBlockRequest $request, UpdateStaticBlockAction $action, $id)
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

        return redirect()->to(route('admin::static-blocks.index.get'));
    }

    /**
     * @param DeleteStaticBlockAction $action
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteStaticBlockAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $request
     * @return mixed
     */
    protected function parseData($request)
    {
        $data = $request->input('static_block', []);
        if (!$data['slug']) {
            $data['slug'] = str_slug($data['title']);
        }
        return $data;
    }
}
