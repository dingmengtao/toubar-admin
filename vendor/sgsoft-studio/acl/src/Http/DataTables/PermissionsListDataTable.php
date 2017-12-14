<?php namespace WebEd\Base\ACL\Http\DataTables;

use WebEd\Base\ACL\Models\Permission;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;

class PermissionsListDataTable extends AbstractDataTables
{
    /**
     * @var Permission
     */
    protected $model;

    /**
     * @var string
     */
    protected $screenName = WEBED_ACL_PERMISSION;

    public function __construct()
    {
        $this->model = do_filter(
            FRONT_FILTER_DATA_TABLES_MODEL,
            Permission::select(['name', 'slug', 'module', 'id']),
            $this->screenName
        );
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id' => [
                'title' => 'ID',
                'width' => '1%',
            ],
            'name' => [
                'title' => trans('webed-acl::datatables.permission.heading.name'),
                'width' => '40%',
            ],
            'slug' => [
                'title' => trans('webed-acl::datatables.permission.heading.slug'),
                'width' => '30%',
            ],
            'module' => [
                'title' => trans('webed-acl::datatables.permission.heading.module'),
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
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'module', 'name' => 'module'],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::acl-permissions.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('name', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->text('slug', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->text('module', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]));

        return $this->view();
    }

    /**
     * @return CollectionDataTable|EloquentDataTable|QueryDataTable|mixed
     */
    public function fetchDataForAjax()
    {
        return webed_datatable()->of($this->model)
            ->editColumn('name', function ($item) {
                if (lang()->has($item->module . '::permissions.' . $item->slug)) {
                    return trans($item->module . '::permissions.' . $item->slug);
                }
                return $item->name;
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
