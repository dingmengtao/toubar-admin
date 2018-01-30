<?php namespace WebEd\Plugins\Miniprograms\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Item\DeleteItemAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Item\UpdateItemAction;
use WebEd\Plugins\Miniprograms\Models\Item;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;

class ItemDataTable extends AbstractDataTables
{
    /**
     * @var BaseModelContract
     */
    protected $model;

    /**
     * @var string
     */
    protected $screenName = WEBED_TOUBAR_ITEM;

    public function __construct()
    {
        $this->model = do_filter(FRONT_FILTER_DATA_TABLES_MODEL, Item::select(['id','user_id', 'name','stage_id','telephone', 'create_time','status', 'order','isgood','isaudit','updated_by']), $this->screenName);
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
            'user_id' => [
                'title' => 'WXTBUser',
                'width' => '10%',
            ],
            'name' => [
                'title' => 'Name',
                'width' => '10%',
            ],
            'stage_id' => [
                'title' => 'Stage',
                'width' => '10%',
            ],
            'telephone' => [
                'title' => 'Telephone',
                'width' => '10%',
            ],
            'isgood' => [
                'title' => 'Isgood',
                'width' => '5%',
            ],
            'isaudit' => [
                'title' => 'Isaudit',
                'width' => '5%',
            ],
            'status' => [
                'title' => trans('webed-core::datatables.heading.status'),
                'width' => '5%',
            ],
            'order' => [
                'title' => trans('webed-core::datatables.heading.order'),
                'width' => '5%',
            ],
            'create_time' => [
                'title' => 'Create_time',
                'width' => '10%',
            ],
            'updated_by' => [
                'title' => 'Updated_by',
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
            ['data' => 'viewID', 'name' => 'id'],
            ['data' => 'user_id', 'name' => 'user_id'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'stage_id', 'name' => 'stage_id'],
            ['data' => 'telephone', 'name' => 'telephone'],
            ['data' => 'isgood', 'name' => 'isgood'],
            ['data' => 'isaudit', 'name' => 'isaudit'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'order', 'name' => 'order', 'searchable' => false],
            ['data' => 'create_time', 'name' => 'create_time'],
            ['data' => 'updated_by', 'name' => 'updated_by'],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::miniprograms.toubar.item.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->text('user_id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->text('name', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(4, form()->text('stage_id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(5, form()->text('telephone', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(6, form()->select('isgood', [
                'without_trashed' => trans('webed-core::datatables.select') . '...',
                1 => trans('精选'),
                0 => trans('非精选'),
            ], null, ['class' => 'form-control form-filter input-sm']))
            ->addFilter(7, form()->select('isaudit', [
                'without_trashed' => trans('webed-core::datatables.select') . '...',
                1 => trans('已审核'),
                0 => trans('未审核'),
                2 => trans('拒绝'),
            ], null, ['class' => 'form-control form-filter input-sm']))
            ->addFilter(11, form()->text('updated_by', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(8, form()->select('status', [
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
            ->rawColumns(['actions','status','isgood','isaudit','updated_by'])
            ->filterColumn('isgood', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                if ($keyword == 1) {
                    return $query->whereNull('delete_time')->where('isgood', '=', $keyword);
                } elseif ($keyword == 0) {
                    return $query->whereNull('delete_time')->where('isgood', '=', $keyword);
                }
            })
            ->filterColumn('isaudit', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                if ($keyword == 1) {
                    return $query->whereNull('delete_time')->where('isaudit', '=', $keyword);
                } elseif ($keyword == 0) {
                    return $query->whereNull('delete_time')->where('isaudit', '=', $keyword);
                }elseif ($keyword == 2) {
                    return $query->whereNull('delete_time')->where('isaudit', '=', $keyword);
                }
            })
            ->filterColumn('status', function ($query, $keyword) {
                if ($keyword === 'deleted') {
                    return $query->whereNotNull('delete_time');
                } else if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                if ($keyword === 'is_featured') {
                    return $query->whereNull('delete_time')->where('is_featured', '=', 1);
                } else {
                    return $query->whereNull('delete_time')->where('status', '=', $keyword);
                }
            })
            ->filterColumn('updated_by', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('updated_by', '=', $keyword);
            })
            ->addColumn('viewID', function ($item) {
                return $item->id;
            })
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
//                if ($item->trashed()) {
                if (!$item->status) {
                    return html()->label(trans('webed-core::base.status.deleted'), 'deleted');
                }

                $status = $item->status ? 'activated' : 'disabled';

                $featured = ($item->is_featured) ? '<br><br>' . html()->label('featured', 'purple') : '';

                return html()->label(trans('webed-core::base.status.' . $status), $status) . $featured;
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::miniprograms.toubar.item.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::miniprograms.toubar.item.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::miniprograms.toubar.item.delete.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::miniprograms.toubar.item.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);
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
            if (!has_permissions(get_current_logged_user(), ['update-item'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['delete-item'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }

                    $action = app(DeleteItemAction::class);

                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 1:
                case 0:
                    $action = app(UpdateItemAction::class);

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
