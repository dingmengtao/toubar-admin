<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Blog\Actions\CreateProductAction;
use WebEd\Plugins\Blog\Actions\DeleteProductAction;
use WebEd\Plugins\Blog\Actions\UpdateProductAction;
use WebEd\Plugins\Blog\Http\DataTables\ProductDataTable;
use WebEd\Plugins\Blog\Http\Requests\CreateProductRequest;
use WebEd\Plugins\Blog\Http\Requests\UpdateProductRequest;
use WebEd\Plugins\Blog\Repositories\Contracts\ProductRepositoryContract;
use WebEd\Plugins\Blog\Repositories\ProductRepository;

use Yajra\DataTables\EloquentDataTable;

class ProductController extends BaseAdminController
{
    protected $module = WEBED_BLOG;


    protected $repository;


    public function __construct(ProductRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink('webed-blog', route('admin::product.posts.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ProductDataTable $dataTables)
    {
        $this->setPageTitle('Product');//设置标题

        $this->dis['dataTable'] = $dataTables->run();//输出HTML


        return do_filter(BASE_FILTER_CONTROLLER, $this,WEBED_BLOG_PRODUCTS, 'index.get', $dataTables)->viewAdmin('product.index');
    }

    /**
     * @param AbstractDataTables $dataTables
     * @return mixed
     */
    public function postListing(ProductDataTable $dataTables)
    {

        return do_filter(BASE_FILTER_CONTROLLER, $dataTables, WEBED_BLOG_POSTS, 'index.post', $this);
    }

    /**
     * @param UpdateProductAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateProductAction $action, $id, $status)
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
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_PRODUCTS, 'create.get');

        /**
         * Place your magic here
         */

        $this->setPageTitle('Create Product');
        $this->breadcrumbs->addLink('Create Product');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_PRODUCTS, 'create.get')->viewAdmin('product.create');
    }

    /**
     * @param CreateProductRequest $request
     * @param CreateProductAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateProductRequest $request, CreateProductAction $action)
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
            return redirect()->to(route('admin::product.posts.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::product.posts.index.get'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_PRODUCTS, 'edit.get');

        if (!$item) {
            flash_messages()
                ->addMessages(trans('webed-core::base.form.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        /**
         * Place your magic here
         */
        $this->dis['object']=$item;
        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_BLOG_PRODUCTS, 'edit.get', $id)->viewAdmin('product.edit');
    }

    /**
     * @param UpdateProductRequest $request
     * @param UpdateProductAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateProductRequest $request, UpdateProductAction $action, $id)
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

        return redirect()->to(route('admin::product.posts.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteProductAction $action, $id)
    {
        $result = $action->run($id, false);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postForceDelete(DeleteProductAction $action, $id)
    {
        $result = $action->run($id, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestore(YourRestoreEntityAction $action, $id)
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
