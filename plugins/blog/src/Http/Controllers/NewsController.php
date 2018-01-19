<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Blog\Actions\News\CreateNewsAction;
use WebEd\Plugins\Blog\Actions\News\DeleteNewsAction;
use WebEd\Plugins\Blog\Actions\News\RestoreNewsAction;
use WebEd\Plugins\Blog\Actions\News\UpdateNewsAction;
use WebEd\Plugins\Blog\Http\DataTables\NewsDataTable;
use WebEd\Plugins\Blog\Http\Requests\News\CreateNewsRequest;
use WebEd\Plugins\Blog\Http\Requests\News\UpdateNewsRequest;
use WebEd\Plugins\Blog\Repositories\Contracts\NewsRepositoryContract;

class NewsController extends BaseAdminController
{
    protected $module = 'webed-blog';

    /**
     * @var YourModuleRepositoryContract|EloquentBaseRepository
     */
    protected $repository;

    /**
     * @param EloquentBaseRepository $repository
     */
    public function __construct(NewsRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink('news', route('admin::blog.news.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(NewsDataTable $dataTables)
    {
        $this->setPageTitle('News');

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_NEWS, 'index.get', $dataTables)->viewAdmin('news.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(NewsDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_BLOG_NEWS, 'index.post', $this);
    }

    /**
     * @param YourUpdateEntityAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateNewsAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_NEWS, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create News');
        $this->breadcrumbs->addLink('Create News');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_NEWS, 'create.get')->viewAdmin('news.create');
    }

    /**
     * @param YourCreateEntityRequest $request
     * @param YourCreateEntityAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateNewsRequest $request, CreateNewsAction $action)
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
            return redirect()->to(route('admin::blog.news.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::blog.news.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_NEWS, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->setPageTitle('Edit news' . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('Edit news'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_NEWS, 'edit.get', $id)->viewAdmin('news.edit');
    }

    /**
     * @param YourUpdateEntityRequest $request
     * @param YourUpdateEntityAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateNewsRequest $request, UpdateNewsAction $action, $id)
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

        return redirect()->to(route('admin::blog.news.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteNewsAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteNewsAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreNewsAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    protected function parseData(\WebEd\Base\Http\Requests\Request $request)
    {
        $data = $request->input('post');
        if (!$data['slug']) {
            $data['slug'] = str_slug($data['title']);
        }

        return $data;
    }
}
