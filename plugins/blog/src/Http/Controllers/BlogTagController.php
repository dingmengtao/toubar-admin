<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Plugins\Blog\Actions\Tags\DeleteTagAction;
use WebEd\Plugins\Blog\Actions\Tags\RestoreTagAction;
use WebEd\Plugins\Blog\Actions\Tags\UpdateTagAction;
use WebEd\Plugins\Blog\Http\DataTables\TagsListDataTable;
use WebEd\Plugins\Blog\Http\Requests\CreateBlogTagRequest;
use WebEd\Plugins\Blog\Http\Requests\UpdateBlogTagRequest;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;
use Yajra\DataTables\EloquentDataTable;

class BlogTagController extends BaseAdminController
{
    protected $module = WEBED_BLOG;

    /**
     * @var BlogTagRepository
     */
    protected $repository;

    public function __construct(BlogTagRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_BLOG_TAGS);

            $this->breadcrumbs
                ->addLink(trans('webed-blog::base.page_title'))
                ->addLink(trans('webed-blog::base.tags.page_title'), route('admin::blog.tags.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables|EloquentDataTable $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(TagsListDataTable $dataTables)
    {
        $this->setPageTitle(trans('webed-blog::base.tags.page_title'));

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_TAGS, 'index.get', $dataTables)->viewAdmin('tags.index');
    }

    /**
     * @param AbstractDataTables|EloquentDataTable $dataTables
     * @return mixed
     */
    public function postListing(TagsListDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_BLOG_TAGS, 'index.post', $this);
    }

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateTagAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_TAGS, 'create.get');

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans('webed-blog::base.tags.form.create_tag'));
        $this->breadcrumbs->addLink(trans('webed-blog::base.tags.form.create_tag'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_TAGS, 'create.get')->viewAdmin('tags.create');
    }

    public function postCreate(CreateBlogTagRequest $request)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_TAGS, 'create.post');

        $data = $this->parseData($request);
        $data['created_by'] = $this->loggedInUser->id;

        $result = $this->repository->createBlogTag($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_TAGS, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        if (!$result) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::blog.tags.edit.get', ['id' => $result]));
        }

        return redirect()->to(route('admin::blog.tags.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_TAGS, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-blog::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans('webed-blog::base.tags.edit_item') . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('webed-blog::base.tags.edit_item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_TAGS, 'edit.get', $id)->viewAdmin('tags.edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateBlogTagRequest $request, $id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_TAGS, 'edit.post');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-blog::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $data = $this->parseData($request);

        $result = $this->repository->updateBlogTag($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_BLOG_TAGS, $id, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        if ($this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::blog.tags.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteTagAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteTagAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreTagAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param \WebEd\Base\Http\Requests\Request $request
     * @return mixed
     */
    protected function parseData($request)
    {
        $data = $request->input('tag', []);
        $data['slug'] = $data['slug'] ? str_slug($data['slug']) : str_slug($data['title']);
        return $data;
    }
}
