<?php namespace WebEd\Base\Menu\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Menu\Models\Menu;

class MenusListDataTable extends AbstractDataTables
{
    protected $model;

    protected $screenName = WEBED_MENUS;

    public function __construct()
    {
        $this->model = do_filter(FRONT_FILTER_DATA_TABLES_MODEL, Menu::select('id', 'created_at', 'title', 'slug', 'status'), $this->screenName);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'title' => [
                'title' => trans('webed-menus::datatables.heading.title'),
                'width' => '25%',
            ],
            'slug' => [
                'title' => trans('webed-menus::datatables.heading.slug'),
                'width' => '25%',
            ],
            'status' => [
                'title' => trans('webed-menus::datatables.heading.status'),
                'width' => '15%',
            ],
            'created_at' => [
                'title' => trans('webed-menus::datatables.heading.created_at'),
                'width' => '15%',
            ],
            'actions' => [
                'title' => trans('webed-core::datatables.heading.actions'),
                'width' => '20%',
            ],
        ];
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::menus.index.post'), 'POST');

        $this
            ->addFilter(0, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(1, form()->text('slug', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->select('status', [
                '' => trans('webed-core::datatables.select') . '...',
                1 => trans('webed-core::base.status.activated'),
                0 => trans('webed-core::base.status.disabled'),
            ], null, ['class' => 'form-control form-filter input-sm']));

        return $this->view();
    }

    /**
     * @return mixed
     */
    protected function fetchDataForAjax()
    {
        return webed_datatable()->of($this->model)
            ->rawColumns(['actions'])
            ->editColumn('status', function ($item) {
                $status = $item->status ? 'activated' : 'disabled';
                return html()->label(trans('webed-core::base.status.' . $status), $status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::menus.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::menus.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::menus.delete.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::menus.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);

                $activeBtn = ($item->status != 1) ? form()->button(trans('webed-core::datatables.active'), [
                    'title' => trans('webed-core::datatables.active_this_item'),
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';

                $disableBtn = ($item->status != 0) ? form()->button(trans('webed-core::datatables.disable'), [
                    'title' => trans('webed-core::datatables.disable_this_item'),
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';

                $deleteBtn = form()->button(trans('webed-core::datatables.delete'), [
                    'title' => trans('webed-core::datatables.delete_this_item'),
                    'data-ajax' => $deleteLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    'type' => 'button',
                ]);

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
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
