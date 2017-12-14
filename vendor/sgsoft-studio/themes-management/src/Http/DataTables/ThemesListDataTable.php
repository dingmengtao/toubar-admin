<?php namespace WebEd\Base\ThemesManagement\Http\DataTables;

use Illuminate\Support\Facades\File;
use WebEd\Base\Http\DataTables\AbstractDataTables;

class ThemesListDataTable extends AbstractDataTables
{
    protected $repository;

    public function __construct()
    {
        $this->repository = get_all_theme_information(false);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'thumbnail' => [
                'title' => trans('webed-themes-management::datatables.heading.thumbnail'),
                'width' => '15%',
            ],
            'name' => [
                'title' => trans('webed-themes-management::datatables.heading.name'),
                'width' => '20%',
            ],
            'description' => [
                'title' => trans('webed-themes-management::datatables.heading.description'),
                'width' => '40%',
            ],
            'actions' => [
                'title' => trans('webed-core::datatables.heading.actions'),
                'width' => '40%',
            ],
        ];
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ['data' => 'thumbnail', 'name' => 'thumbnail', 'searchable' => false, 'orderable' => false],
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
        $this->setAjaxUrl(route('admin::themes.index.post'), 'POST');

        return $this->view();
    }

    /**
     * @return mixed
     */
    protected function fetchDataForAjax()
    {
        return webed_datatable()->of($this->repository)
            ->rawColumns(['description', 'actions', 'thumbnail'])
            ->editColumn('description', function ($item) {
                return array_get($item, 'description') . '<br><br>'
                    . trans('webed-themes-management::datatables.author') . ': <b>' . array_get($item, 'author') . '</b><br>'
                    . trans('webed-themes-management::datatables.version') . ': <b>' . array_get($item, 'version', '...') . '</b>' . '<br>'
                    . trans('webed-themes-management::datatables.installed_version') . ': <b>' . (array_get($item, 'installed_version') ?: '...') . '</b>';
            })
            ->addColumn('thumbnail', function ($item) {
                $themeFolder = get_base_folder($item['file']);
                $themeThumbnail = $themeFolder . 'theme.jpg';
                if (!File::exists($themeThumbnail)) {
                    $themeThumbnail = webed_themes_path('default-thumbnail.jpg');
                }
                $imageData = base64_encode(File::get($themeThumbnail));
                $src = 'data: ' . mime_content_type($themeThumbnail) . ';base64,' . $imageData;
                return '<img src="' . $src . '" alt="' . array_get($item, 'alias') . '" width="240" height="180" class="theme-thumbnail">';
            })
            ->addColumn('actions', function ($item) {
                $activeBtn = (!array_get($item, 'enabled')) ? form()->button(trans('webed-themes-management::datatables.active'), [
                    'title' => trans('webed-themes-management::datatables.active_this_theme'),
                    'data-ajax' => route('admin::themes.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 1,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';
                $disableBtn = (array_get($item, 'enabled')) ? form()->button(trans('webed-themes-management::datatables.disable'), [
                    'title' => trans('webed-themes-management::datatables.disable_this_theme'),
                    'data-ajax' => route('admin::themes.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 0,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';

                $installBtn = (array_get($item, 'enabled') && !array_get($item, 'installed')) ? form()->button(trans('webed-themes-management::datatables.install'), [
                    'title' => trans('webed-themes-management::datatables.install_this_theme'),
                    'data-ajax' => route('admin::themes.install.post', [
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
                    ? form()->button(trans('webed-themes-management::datatables.update'), [
                        'title' => trans('webed-themes-management::datatables.update_this_theme'),
                        'data-ajax' => route('admin::themes.update.post', [
                            'module' => array_get($item, 'alias'),
                        ]),
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline purple btn-sm ajax-link',
                    ])
                    : '';

                $uninstallBtn = (array_get($item, 'enabled') && array_get($item, 'installed')) ? form()->button(trans('webed-themes-management::datatables.uninstall'), [
                    'title' => trans('webed-themes-management::datatables.uninstall_this_theme'),
                    'data-ajax' => route('admin::themes.uninstall.post', [
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
