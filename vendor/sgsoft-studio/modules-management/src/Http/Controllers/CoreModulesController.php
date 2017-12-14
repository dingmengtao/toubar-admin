<?php namespace WebEd\Base\ModulesManagement\Http\Controllers;

use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\ModulesManagement\Actions\UpdateCoreModuleAction;
use WebEd\Base\ModulesManagement\Http\DataTables\CoreModulesListDataTable;

class CoreModulesController extends BaseAdminController
{
    /**
     * @var string
     */
    protected $module = WEBED_MODULES_MANAGEMENT;

    /**
     * @var string
     */
    protected $dashboardMenuId = 'webed-core-modules';

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(CoreModulesListDataTable $dataTable)
    {
        $this->breadcrumbs->addLink(trans($this->module . '::base.plugins'));

        $this->setPageTitle(trans($this->module . '::base.core_modules'));

        $this->getDashboardMenu($this->dashboardMenuId);

        $this->dis['dataTable'] = $dataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_CORE_MODULES, 'index.get', $dataTable)->viewAdmin('core-modules-list');
    }

    /**
     * Set data for DataTable plugin
     * @param CoreModulesListDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(CoreModulesListDataTable $dataTable)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $dataTable, WEBED_CORE_MODULES, 'index.post', $this);
    }

    /**
     * @param UpdateCoreModuleAction $action
     * @param $alias
     * @return array
     */
    public function postUpdate(UpdateCoreModuleAction $action, $alias)
    {
        $result = $action->run($alias);

        return response()->json($result, $result['response_code']);
    }
}
