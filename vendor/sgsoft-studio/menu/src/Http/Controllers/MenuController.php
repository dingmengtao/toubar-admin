<?php namespace WebEd\Base\Menu\Http\Controllers;

use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\Requests\Request;
use WebEd\Base\Menu\Actions\CreateMenuAction;
use WebEd\Base\Menu\Actions\DeleteMenuAction;
use WebEd\Base\Menu\Actions\UpdateMenuAction;
use WebEd\Base\Menu\Http\DataTables\MenusListDataTable;
use WebEd\Base\Menu\Http\Requests\CreateMenuRequest;
use WebEd\Base\Menu\Http\Requests\UpdateMenuRequest;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuRepository;

class MenuController extends BaseAdminController
{
    protected $module = WEBED_MENUS;

    /**
     * @param MenuRepository $repository
     */
    public function __construct(MenuRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function ($request, $next) {
            $this->getDashboardMenu($this->module);

            $this->breadcrumbs->addLink(trans($this->module . '::base.menus'), route('admin::menus.index.get'));

            return $next($request);
        });
    }

    /**
     * @param MenusListDataTable $menusListDataTable
     * @return mixed
     */
    public function getIndex(MenusListDataTable $menusListDataTable)
    {
        $this->setPageTitle(trans($this->module . '::base.menus_management'));

        $this->dis['dataTable'] = $menusListDataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_MENUS, 'index.get')->viewAdmin('list');
    }

    /**
     * @param MenusListDataTable $menusListDataTable
     * @return mixed
     */
    public function postListing(MenusListDataTable $menusListDataTable)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $menusListDataTable, WEBED_MENUS, 'index.post', $this);
    }

    /**
     * @param UpdateMenuAction $action
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus(UpdateMenuAction $action, $id, $status)
    {
        $result = $action->run($id, [
            'status' => $status
        ]);

        return response()->json($result, $result['response_code']);
    }

    /**
     * Go to create menu page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $this->assets
            ->addStylesheets('jquery-nestable')
            ->addStylesheetsDirectly(asset('admin/modules/menu/menu-nestable.css'))
            ->addJavascripts('jquery-nestable')
            ->addJavascriptsDirectly(asset('admin/modules/menu/edit-menu.js'));

        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_MENUS, 'create.get');

        $this->setPageTitle(trans($this->module . '::base.create_menu'));
        $this->breadcrumbs->addLink(trans($this->module . '::base.create_menu'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_MENUS, 'create.get')->viewAdmin('create');
    }

    /**
     * @param CreateMenuRequest $request
     * @param CreateMenuAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateMenuRequest $request, CreateMenuAction $action)
    {
        $data = $this->parseData($request);

        $menuStructure = json_decode($this->request->input('menu_structure'), true);

        $result = $action->run($data, $menuStructure);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($request->has('_continue_edit')) {
            return redirect()->to(route('admin::menus.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::menus.index.get'));
    }

    /**
     * Go to edit menu page
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->getMenu($id);
        if (!$item) {
            flash_messages()
                ->addMessages(trans($this->module . '::base.menu_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_MENUS, 'edit.get');

        $this->assets
            ->addStylesheets('jquery-nestable')
            ->addStylesheetsDirectly(asset('admin/modules/menu/menu-nestable.css'))
            ->addJavascripts('jquery-nestable')
            ->addJavascriptsDirectly(asset('admin/modules/menu/edit-menu.js'));

        $this->setPageTitle(trans($this->module . '::base.edit_menu'), '#' . $item->id);
        $this->breadcrumbs->addLink(trans($this->module . '::base.edit_menu'));

        $this->dis['menuStructure'] = json_encode($item->all_menu_nodes);

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_MENUS, 'edit.get', $id)->viewAdmin('edit');
    }

    /**
     * @param UpdateMenuRequest $request
     * @param UpdateMenuAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateMenuRequest $request, UpdateMenuAction $action, $id)
    {
        $data = $this->parseData($request);
        $deletedNodes = json_decode($this->request->input('deleted_nodes'), true);
        $menuStructure = json_decode($this->request->input('menu_structure'), true);

        $result = $action->run($id, $data, $menuStructure, $deletedNodes);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error'] || $this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::menus.index.get'));
    }

    /**
     * Delete menu
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(DeleteMenuAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function parseData(Request $request)
    {
        return [
            'menu_structure' => $request->input('menu_structure'),
            'deleted_nodes' => $request->input('deleted_nodes'),
            'status' => $request->input('status'),
            'title' => $request->input('title'),
            'slug' => ($request->input('slug') ? str_slug($request->input('slug')) : str_slug($request->input('title'))),
        ];
    }
}
