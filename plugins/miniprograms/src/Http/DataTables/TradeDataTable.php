<?php namespace WebEd\Plugins\Miniprograms\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Trade\DeleteTradeAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\Trade\UpdateTradeAction;
use WebEd\Plugins\Miniprograms\Models\Trade;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;

class TradeDataTable extends AbstractDataTables
{
    /**
     * @var BaseModelContract
     */
    protected $model;

    /**
     * @var string
     */
    protected $screenName = WEBED_TOUBAR_TRADE;

    public function __construct()
    {
        $this->model = do_filter(FRONT_FILTER_DATA_TABLES_MODEL,Trade::select(['id', 'name', 'create_time','status', 'order','type','created_by']),$this->screenName);
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
            'name' => [
                'title' => 'Name',
                'width' => '15%',
            ],
            'type' => [
                'title' => 'Type',
                'width' => '10%',
            ],
            'status' => [
                'title' => trans('webed-core::datatables.heading.status'),
                'width' => '10%',
            ],
            'order' => [
                'title' => trans('webed-core::datatables.heading.order'),
                'width' => '10%',
            ],
            'create_time' => [
                'title' => 'Create_time',
                'width' => '20%',
            ],
            'created_by' => [
                'title' => 'Created_by',
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
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'type', 'name' => 'type'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'order', 'name' => 'order', 'searchable' => false],
            ['data' => 'create_time', 'name' => 'create_time'],
            ['data' => 'created_by', 'name' => 'created_by'],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::miniprograms.toubar.trade.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->text('name', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->text('type', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(7, form()->text('created_by', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(4, form()->select('status', [
                'without_trashed' => trans('webed-core::datatables.select') . '...',
                1 => trans('webed-core::base.status.activated'),
                0 => trans('webed-core::base.status.disabled'),
                'deleted' => trans('webed-core::base.status.deleted'),
//                'is_featured' => 'Featured',
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
            ->rawColumns(['actions','status','type','created_by'])
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
            ->filterColumn('type', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('type', '=', $keyword);
            })
            ->filterColumn('created_by', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('created_by', '=', $keyword);
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
                $activeLink = route('admin::miniprograms.toubar.trade.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::miniprograms.toubar.trade.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::miniprograms.toubar.trade.delete.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::miniprograms.toubar.trade.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);
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
            if (!has_permissions(get_current_logged_user(), ['update-trade'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['delete-trade'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }

                    $action = app(DeleteTradeAction::class);

                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 1:
                case 0:
                    $action = app(UpdateTradeAction::class);

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
