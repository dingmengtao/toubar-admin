<?php namespace WebEd\Base\ModulesManagement\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;

class PluginsListDataTable extends AbstractDataTables
{
    protected $repository;

    public function __construct()
    {
        $this->repository = get_plugin();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'name' => [
                'title' => trans('webed-modules-management::datatables.heading.name'),
                'width' => '20%',
            ],
            'description' => [
                'title' => trans('webed-modules-management::datatables.heading.description'),
                'width' => '50%',
            ],
            'actions' => [
                'title' => trans('webed-core::datatables.heading.actions'),
                'width' => '30%',
            ],
        ];
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'searchable' => false, 'orderable' => false],
            ['data' => 'description', 'name' => 'description', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::plugins.index.post'), 'POST');

        return $this->view();
    }

    /**
     * @return mixed
     */
    protected function fetchDataForAjax()
    {
        return webed_datatable()->of($this->repository)
            ->rawColumns(['description', 'actions'])
            ->editColumn('description', function ($item) {
                return array_get($item, 'description') . '<br><br>'
                    . trans('webed-modules-management::datatables.author') . ': <b>' . array_get($item, 'author') . '</b><br>'
                    . trans('webed-modules-management::datatables.version') . ': <b>' . array_get($item, 'version', '...') . '</b><br>'
                    . trans('webed-modules-management::datatables.installed_version') . ': <b>' . (array_get($item, 'installed_version', '...') ?: '...') . '</b>';
            })
            ->addColumn('actions', function ($item) {
                $activeBtn = (!array_get($item, 'enabled')) ? form()->button(trans('webed-modules-management::datatables.active'), [
                    'title' => trans('webed-modules-management::datatables.active_this_plugin'),
                    'data-ajax' => route('admin::plugins.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 1,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline green btn-sm ajax-link',
                ]) : '';

                $disableBtn = (array_get($item, 'enabled')) ? form()->button(trans('webed-modules-management::datatables.disable'), [
                    'title' => trans('webed-modules-management::datatables.disable_this_plugin'),
                    'data-ajax' => route('admin::plugins.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 0,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';

                $installBtn = (array_get($item, 'enabled') && !array_get($item, 'installed')) ? form()->button(trans('webed-modules-management::datatables.install'), [
                    'title' => trans('webed-modules-management::datatables.install_this_plugin'),
                    'data-ajax' => route('admin::plugins.install.post', [
                        'module' => array_get($item, 'alias'),
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';

                $updateBtn = (
                    array_get($item, 'enabled') &&
                    array_get($item, 'installed') &&
                    version_compare(array_get($item, 'installed_version'), array_get($item, 'version'), '<')
                )
                    ? form()->button(trans('webed-modules-management::datatables.update'), [
                        'title' => trans('webed-modules-management::datatables.update_this_plugin'),
                        'data-ajax' => route('admin::plugins.update.post', [
                            'module' => array_get($item, 'alias'),
                        ]),
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline purple btn-sm ajax-link',
                    ])
                    : '';

                $uninstallBtn = (array_get($item, 'enabled') && array_get($item, 'installed')) ? form()->button(trans('webed-modules-management::datatables.uninstall'), [
                    'title' => trans('webed-modules-management::datatables.uninstall_this_plugin'),
                    'data-ajax' => route('admin::plugins.uninstall.post', [
                        'module' => array_get($item, 'alias'),
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]) : '';

                return $activeBtn . $disableBtn . $installBtn . $updateBtn . $uninstallBtn;
            });
    }

    /**
     * @return array
     */
    protected function groupAction(): array
    {
        return [];
    }
}
