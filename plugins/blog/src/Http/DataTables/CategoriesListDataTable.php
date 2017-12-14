<?php namespace WebEd\Plugins\Blog\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Plugins\Blog\Actions\Categories\DeleteCategoryAction;
use WebEd\Plugins\Blog\Actions\Categories\RestoreCategoryAction;
use WebEd\Plugins\Blog\Actions\Categories\UpdateCategoryAction;

class CategoriesListDataTable extends AbstractDataTables
{
    protected $screenName = WEBED_BLOG_CATEGORIES;

    public function __construct()
    {
        $categories = collect(get_categories([], has_permissions(get_current_logged_user(), [
            'force-delete-categories', 'restore-categories',
        ])));

        $this->model = do_filter(FRONT_FILTER_DATA_TABLES_MODEL, $categories, $this->screenName);
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
            ['data' => 'viewID', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'title', 'name' => 'title', 'searchable' => false, 'orderable' => false],
            ['data' => 'page_template', 'name' => 'page_template', 'orderable' => false],
            ['data' => 'status', 'name' => 'status', 'searchable' => false, 'orderable' => false],
            ['data' => 'order', 'name' => 'order', 'searchable' => false, 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::blog.categories.index.post'), 'POST');

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'deleted' => trans('webed-core::datatables.delete_these_items'),
            'restore' => trans('webed-core::datatables.restore_these_items'),
            1 => trans('webed-core::datatables.active_these_items'),
            0 => trans('webed-core::datatables.disable_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return mixed
     */
    protected function fetchDataForAjax()
    {
        return webed_datatable()->of($this->model)
            ->rawColumns(['actions'])
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->addColumn('viewID', function ($item) {
                return $item->id;
            })
            ->editColumn('title', function ($item) {
                return $item->indent_text . $item->title;
            })
            ->editColumn('page_template', function ($item) {
                if (!$item->page_template) {
                    return $item->page_template;
                }
                $templates = get_templates(WEBED_BLOG_CATEGORIES);
                return array_get($templates, $item->page_template);
            })
            ->editColumn('status', function ($item) {
                if ($item->trashed()) {
                    return html()->label(trans('webed-core::base.status.deleted'), 'deleted');
                }

                $status = $item->status ? 'activated' : 'disabled';
                return html()->label(trans('webed-core::base.status.' . $status), $status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::blog.categories.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::blog.categories.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::blog.categories.delete.post', ['id' => $item->id]);
                $forceDelete = route('admin::blog.categories.force-delete.post', ['id' => $item->id]);
                $restoreLink = route('admin::blog.categories.restore.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::blog.categories.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);

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
            if (!has_permissions(get_current_logged_user(), ['update-categories'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'restore':
                    $action = app(RestoreCategoryAction::class);

                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['delete-categories'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }
                    /**
                     * Delete items
                     */
                    $action = app(DeleteCategoryAction::class);
                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 0:
                case 1:
                    $action = app(UpdateCategoryAction::class);

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
