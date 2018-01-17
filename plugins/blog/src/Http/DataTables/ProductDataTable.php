<?php namespace WebEd\Plugins\Blog\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Models\Contracts\BaseModelContract;

use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;
use WebEd\Plugins\Blog\Models\Product;

class ProductDataTable extends AbstractDataTables
{
    /**
     * @var BaseModelContract
     */
    protected $model;

    /**
     * @var string
     */
    protected $screenName = WEBED_BLOG_PRODUCTS;

    public function __construct()
    {
        $this->model = do_filter(FRONT_FILTER_DATA_TABLES_MODEL, Product::select(['id', 'created_at', 'title', 'page_template', 'status', 'order', 'is_featured', 'deleted_at']), $this->screenName);

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
                'width' => '30%',
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
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
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
        $this->setAjaxUrl(route('admin::product.posts.index.post'), 'POST');


        $this
            ->addFilter(1, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]));

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
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
                if ($item->trashed()) {
                    return html()->label(trans('webed-core::base.status.deleted'), 'deleted');
                }

                $status = $item->status ? 'activated' : 'disabled';

                $featured = ($item->is_featured) ? '<br><br>' . html()->label('featured', 'purple') : '';

//                return html()->label(trans('webed-core::base.status.' . $status), $status) . $featured;
                return html()->label(trans('webed-core::base.status.' . $status), $status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::product.posts.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::product.posts.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::product.posts.delete.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::product.posts.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);
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
     * Handle group actions
     * @return array
     */
    protected function groupAction(): array
    {
        $request = request();

        $data = [];

        if ($request->input('customActionType', null) === 'group_action') {
            if (!has_permissions(get_current_logged_user(), ['your-update-permission-here'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['your-delete-permission-here'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }

                    $action = app(YourDeleteAction::class);

                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 1:
                case 0:
                    $action = app(YourUpdateAction::class);

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
