<?php namespace WebEd\Base\Pages\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Pages\Actions\DeletePageAction;
use WebEd\Base\Pages\Actions\UpdatePageAction;
use WebEd\Base\Pages\Models\Page;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;

class PagesListDataTable extends AbstractDataTables
{
    /**
     * @var Page
     */
    protected $model;

    protected $screenName = WEBED_PAGES;

    public function __construct()
    {
        $this->model = do_filter(
            FRONT_FILTER_DATA_TABLES_MODEL,
            Page::select('id', 'page_template', 'status', 'title', 'order', 'created_at', 'deleted_at')->withTrashed(),
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
                'width' => '5%',
            ],
            'title' => [
                'title' => trans('webed-core::datatables.heading.title'),
                'width' => '25%',
            ],
            'page_template' => [
                'title' => trans('webed-core::datatables.heading.page_template'),
                'width' => '15%',
            ],
            'status' => [
                'title' => trans('webed-core::datatables.heading.status'),
                'width' => '10%',
            ],
            'order' => [
                'title' => trans('webed-core::datatables.heading.order'),
                'width' => '10%',
            ],
            'created_at' => [
                'title' => trans('webed-core::datatables.heading.created_at'),
                'width' => '10%',
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
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'viewID', 'name' => 'id'],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'page_template', 'name' => 'page_template'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'order', 'name' => 'order', 'searchable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::pages.index.post'), 'POST');

        $templates = ['' => trans('webed-core::datatables.select') . '...',] + get_templates(WEBED_PAGES);

        $this
            ->addFilter(1, form()->text('id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => '...'
            ]))
            ->addFilter(2, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->select('page_template', $templates, null, [
                'class' => 'form-control form-filter input-sm',
            ]))
            ->addFilter(4, form()->select('status', [
                'without_trashed' => trans('webed-core::datatables.select') . '...',
                1 => trans('webed-core::base.status.activated'),
                0 => trans('webed-core::base.status.disabled'),
                'deleted' => trans('webed-core::base.status.deleted'),
            ], null, ['class' => 'form-control form-filter input-sm']));

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'deleted' => trans('webed-core::datatables.delete_these_items'),
            1 => trans('webed-core::datatables.active_these_items'),
            0 => trans('webed-core::datatables.disable_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return CollectionDataTable|EloquentDataTable|QueryDataTable|mixed
     */
    protected function fetchDataForAjax()
    {
        return webed_datatable()->of($this->model)
            ->rawColumns(['actions'])
            ->filterColumn('status', function ($query, $keyword) {
                if ($keyword === 'deleted') {
                    return $query->whereNotNull('deleted_at');
                } else if ($keyword == 'without_trashed') {
                    return $query->whereNull('deleted_at');
                }

                return $query
                    ->whereNull('deleted_at')
                    ->where('status', '=', $keyword);
            })
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
                if ($item->trashed()) {
                    return html()->label(trans('webed-core::base.status.deleted'), 'deleted');
                }

                $status = $item->status ? 'activated' : 'disabled';
                return html()->label(trans('webed-core::base.status.' . $status), $status);
            })
            ->editColumn('page_template', function ($item) {
                if (!$item->page_template) {
                    return $item->page_template;
                }
                $templates = get_templates(WEBED_PAGES);
                return array_get($templates, $item->page_template);
            })
            ->addColumn('viewID', function ($item) {
                return $item->id;
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::pages.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::pages.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::pages.delete.post', ['id' => $item->id]);
                $forceDelete = route('admin::pages.force-delete.post', ['id' => $item->id]);
                $restoreLink = route('admin::pages.restore.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::pages.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-outline green btn-sm']);

                $activeBtn = ($item->status != 1 && !$item->trashed()) ? form()->button(trans('webed-core::datatables.active'), [
                    'title' => trans('webed-core::datatables.active_this_item'),
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';
                $disableBtn = ($item->status != 0 && !$item->trashed()) ? form()->button(trans('webed-core::datatables.disable'), [
                    'title' => trans('webed-core::datatables.disable_this_item'),
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';

                $deleteBtn = (!$item->trashed())
                    ? form()->button(trans('webed-core::datatables.delete'), [
                        'title' => trans('webed-core::datatables.delete_this_item'),
                        'data-ajax' => $deleteLink,
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    ])
                    : form()->button(trans('webed-core::datatables.force_delete'), [
                        'title' => trans('webed-core::datatables.force_delete_this_item'),
                        'data-ajax' => $forceDelete,
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    ]) . form()->button(trans('webed-core::datatables.restore'), [
                        'title' => trans('webed-core::datatables.restore_this_item'),
                        'data-ajax' => $restoreLink,
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline blue btn-sm ajax-link',
                    ]);

                $activeBtn = ($item->status != 1) ? $activeBtn : '';
                $disableBtn = ($item->status != 0) ? $disableBtn : '';

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });
    }

    /**
     * Handle group actions
     * @return array
     */
    protected function groupAction(): array
    {
        $request = request();

        $data = [];
        if ($request->input('customActionType', null) === 'group_action') {
            if (!has_permissions(get_current_logged_user(), ['edit-pages'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['delete-pages'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }
                    /**
                     * Delete pages
                     */
                    $action = app(DeletePageAction::class);

                    foreach ($ids as $id) {
                        $action->run($action, $id);
                    }
                    break;
                case 1:
                case 0:
                    $action = app(UpdatePageAction::class);

                    foreach ($ids as $id) {
                        $action->run($id, [
                            'status' => $actionValue,
                        ]);
                    }
                    break;
                default:
                    return [
                        'customActionMessage' => trans('webed-core::errors.' . \Constants::METHOD_NOT_ALLOWED . '.message'),
                        'customActionStatus' => 'danger'
                    ];
                    break;
            }
            $data['customActionMessage'] = trans('webed-core::base.form.request_completed');
            $data['customActionStatus'] = 'success';
        }

        return $data;
    }
}
