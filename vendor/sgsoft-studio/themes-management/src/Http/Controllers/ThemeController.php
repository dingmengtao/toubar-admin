<?php namespace WebEd\Base\ThemesManagement\Http\Controllers;

use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\ThemesManagement\Actions\DisableThemeAction;
use WebEd\Base\ThemesManagement\Actions\EnableThemeAction;
use WebEd\Base\ThemesManagement\Actions\InstallThemeAction;
use WebEd\Base\ThemesManagement\Actions\UninstallThemeAction;
use WebEd\Base\ThemesManagement\Actions\UpdateThemeAction;
use WebEd\Base\ThemesManagement\Http\DataTables\ThemesListDataTable;

class ThemeController extends BaseAdminController
{
    protected $module = WEBED_THEMES_MANAGEMENT;

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ThemesListDataTable $themesListDataTable)
    {
        $this->getDashboardMenu($this->module);

        $this->breadcrumbs->addLink(trans($this->module . '::base.themes'));
        $this->setPageTitle(trans($this->module . '::base.themes'));

        $this->dis['dataTable'] = $themesListDataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_THEMES_MANAGEMENT, 'index.get')->viewAdmin('list');
    }

    /**
     * Set data for DataTable plugin
     * @param ThemesListDataTable $themesListDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(ThemesListDataTable $themesListDataTable)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $themesListDataTable, WEBED_THEMES_MANAGEMENT, 'index.post', $this);
    }

    /**
     * @param $alias
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postChangeStatus($alias, $status)
    {
        switch ((bool)$status) {
            case true:
                $result = app(EnableThemeAction::class)->run($alias);
                break;
            default:
                $result = app(DisableThemeAction::class)->run($alias);
                break;
        }
        return response()->json($result, $result['response_code']);
    }

    /**
     * @param InstallThemeAction $action
     * @param $alias
     * @return \Illuminate\Http\JsonResponse
     */
    public function postInstall(InstallThemeAction $action, $alias)
    {
        $result = $action->run($alias);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param UpdateThemeAction $action
     * @param $alias
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdate(UpdateThemeAction $action, $alias)
    {
        $result = $action->run($alias);

        return response()->json($result, $result['response_code']);
    }

    /**
     * @param UninstallThemeAction $action
     * @param $alias
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUninstall(UninstallThemeAction $action, $alias)
    {
        $result = $action->run($alias);

        return response()->json($result, $result['response_code']);
    }
}
