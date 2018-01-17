<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Plugins\Blog\Actions\Posts\CreatePostAction;
use WebEd\Plugins\Blog\Actions\Posts\DeletePostAction;
use WebEd\Plugins\Blog\Actions\Posts\RestorePostAction;
use WebEd\Plugins\Blog\Actions\Posts\UpdatePostAction;
use WebEd\Plugins\Blog\Http\DataTables\PostsListDataTable;
use WebEd\Plugins\Blog\Http\Requests\CreatePostRequest;
use WebEd\Plugins\Blog\Http\Requests\UpdatePostRequest;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;
use Yajra\DataTables\EloquentDataTable;

class PostController extends BaseAdminController
{
    protected $module = WEBED_BLOG;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @param PostRepository $repository
     */
    public function __construct(PostRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_BLOG_POSTS);

            $this->breadcrumbs
                ->addLink(trans('webed-blog::base.page_title'))
                ->addLink(trans('webed-blog::base.posts.page_title'), route('admin::blog.posts.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables|EloquentDataTable $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(PostsListDataTable $dataTables)
    {
        $this->setPageTitle(trans('webed-blog::base.posts.page_title'));

        $this->dis['dataTable'] = $dataTables->run();



        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_POSTS, 'index.get', $dataTables)->viewAdmin('posts.index');
    }

    /**
     * @param AbstractDataTables|EloquentDataTable $dataTables
     * @return mixed
     */
    public function postListing(PostsListDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_BLOG_POSTS, 'index.post', $this);
    }

    /**
     * @param UpdatePostAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdatePostAction $action, $id, $status)
    {
        $result = $action->run($id, [
            'status' => $status
        ]);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param BlogTagRepository $blogTagRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate(BlogTagRepositoryContract $blogTagRepository)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_POSTS, 'create.get');

        $allCategories = get_categories();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allCategories as $category) {
            $selectArr[$category->id] = $category->indent_text . $category->title;
        }
        $this->dis['baseCategories'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor',
                'jquery-select2'
            ])
            ->addStylesheets(['jquery-select2']);

        $this->dis['categories'] = get_categories_with_children();
        $this->dis['tags'] = $blogTagRepository
            ->get(['id', 'title'])
            ->pluck('title', 'id')
            ->toArray();

        $this->setPageTitle(trans('webed-blog::base.posts.form.create_post'));
        $this->breadcrumbs->addLink(trans('webed-blog::base.posts.form.create_post'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_POSTS, 'create.get')->viewAdmin('posts.create');
    }

    /**
     * @param CreatePostRequest $request
     * @param CreatePostAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreatePostRequest $request, CreatePostAction $action)
    {
        $data = $this->parseData($request);

        $result = $action->run($data, $request->input('categories', []), $request->input('tags', []));

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::blog.posts.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::blog.posts.index.get'));
    }

    /**
     * @param BlogTagRepository $blogTagRepository
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit(BlogTagRepositoryContract $blogTagRepository, $id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_POSTS, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-blog::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $allCategories = get_categories();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allCategories as $category) {
            $selectArr[$category->id] = $category->indent_text . $category->title;
        }
        $this->dis['baseCategories'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor',
                'jquery-select2'
            ])
            ->addStylesheets(['jquery-select2']);

        $this->dis['categories'] = get_categories_with_children();
        $this->dis['selectedCategories'] = $this->repository->getRelatedCategoryIds($item);

        $this->dis['tags'] = $blogTagRepository
            ->get(['id', 'title'])
            ->pluck('title', 'id')
            ->toArray();
        $this->dis['selectedTags'] = $this->repository->getRelatedTagIds($item);

        $this->setPageTitle(trans('webed-blog::base.posts.form.edit_item') . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('webed-blog::base.posts.form.edit_item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_POSTS, 'edit.get', $id)->viewAdmin('posts.edit');
    }

    /**
     * @param UpdatePostRequest $request
     * @param UpdatePostAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdatePostRequest $request, UpdatePostAction $action, $id)
    {
        $data = $this->parseData($request);

        $result = $action->run($id, $data, $request->input('categories', []), $request->input('tags', []));

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error'] || $this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::blog.posts.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeletePostAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeletePostAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestorePostAction $action, $id)
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
    public function read(Request $request){

    }
}
