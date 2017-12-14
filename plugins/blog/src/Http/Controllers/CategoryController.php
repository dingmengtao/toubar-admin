<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Plugins\Blog\Actions\Categories\CreateCategoryAction;
use WebEd\Plugins\Blog\Actions\Categories\DeleteCategoryAction;
use WebEd\Plugins\Blog\Actions\Categories\RestoreCategoryAction;
use WebEd\Plugins\Blog\Actions\Categories\UpdateCategoryAction;
use WebEd\Plugins\Blog\Http\DataTables\CategoriesListDataTable;
use WebEd\Plugins\Blog\Http\Requests\CreateCategoryRequest;
use WebEd\Plugins\Blog\Http\Requests\UpdateCategoryRequest;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use Yajra\DataTables\CollectionDataTable;

class CategoryController extends BaseAdminController
{
    protected $module = WEBED_BLOG;

    /**
     * @var CategoryRepository
     */
    protected $repository;

    public function __construct(CategoryRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu(WEBED_BLOG_CATEGORIES);

            $this->breadcrumbs
                ->addLink(trans('webed-blog::base.page_title'))
                ->addLink(trans('webed-blog::base.categories.page_title'), route('admin::blog.categories.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables|CollectionDataTable $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(CategoriesListDataTable $dataTables)
    {
        $this->setPageTitle(trans('webed-blog::base.categories.page_title'));

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_CATEGORIES, 'index.get', $dataTables)->viewAdmin('categories.index');
    }

    /**
     * @param AbstractDataTables|CollectionDataTable $dataTables
     * @return mixed
     */
    public function postListing(CategoriesListDataTable $dataTables)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_BLOG_CATEGORIES, 'index.post', $this);
    }

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateCategoryAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_CATEGORIES, 'create.get');

        $allCategories = get_categories();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allCategories as $category) {
            $selectArr[$category->id] = $category->indent_text . $category->title;
        }
        $this->dis['categories'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans('webed-blog::base.categories.form.create_category'));
        $this->breadcrumbs->addLink(trans('webed-blog::base.categories.form.create_category'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_CATEGORIES, 'create.get')->viewAdmin('categories.create');
    }

    public function postCreate(CreateCategoryRequest $request, CreateCategoryAction $action)
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
            return redirect()->to(route('admin::blog.categories.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::blog.categories.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_CATEGORIES, 'edit.get');

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

        $categories = get_categories();
        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        $childrenIds = $this->repository->getAllRelatedChildrenIds($item) ?: [];
        $childCategories = array_merge($childrenIds, [$id]);
        foreach ($categories as $category) {
            if (!in_array($category->id, $childCategories)) {
                $selectArr[$category->id] = $category->indent_text . $category->title;
            }
        }
        $this->dis['categories'] = $selectArr;

        $this->setPageTitle(trans('webed-blog::base.categories.edit_item') . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('webed-blog::base.categories.edit_item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_CATEGORIES, 'edit.get', $id)
            ->viewAdmin('categories.edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateCategoryRequest $request, UpdateCategoryAction $action, $id)
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

        return redirect()->to(route('admin::blog.categories.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteCategoryAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteCategoryAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(RestoreCategoryAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param \WebEd\Base\Http\Requests\Request $request
     * @return mixed
     */
    protected function parseData(\WebEd\Base\Http\Requests\Request $request)
    {
        $data = $request->input('category', []);
        if (!$data['slug']) {
            $data['slug'] = str_slug($data['title']);
        }
        return $data;
    }
}
