<?php namespace WebEd\Plugins\Miniprograms\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Plugins\Miniprograms\Actions\Toubar\WXTBUser\DeleteWXTBUserAction;
use WebEd\Plugins\Miniprograms\Actions\Toubar\WXTBUser\UpdateWXTBUserAction;
use WebEd\Plugins\Miniprograms\Models\WXTBUser;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;

class WXTBUserDataTable extends AbstractDataTables
{
    /**
     * @var BaseModelContract
     */
    protected $model;

    /**
     * @var string
     */
    protected $screenName = WEBED_TOUBAR_USER;

    public function __construct()
    {
        $this->model = do_filter(FRONT_FILTER_DATA_TABLES_MODEL,
            WXTBUser::select(['id','openid','nickname','country','province','city','gender','language','create_time','status','order','created_by']),
            $this->screenName);
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
            'openid' => [
                'title' => 'OpenID',
                'width' => '15%',
            ],
            'nickname' => [
                'title' => 'Nickname',
                'width' => '10%',
            ],
            'country' => [
                'title' => 'Country',
                'width' => '10%',
            ],
            'province' => [
                'title' => 'Province',
                'width' => '10%',
            ],
            'city' => [
                'title' => 'City',
                'width' => '10%',
            ],
            'gender' => [
                'title' => 'Gender',
                'width' => '10%',
            ],
            'language' => [
                'title' => 'Language',
                'width' => '10%',
            ],
            'order' => [
                'title' => trans('webed-core::datatables.heading.order'),
                'width' => '5%',
            ],
            'create_time' => [
                'title' => 'Create_time',
                'width' => '10%',
            ],
            'created_by' => [
                'title' => 'Created_by',
                'width' => '5%',
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
            ['data' => 'openid', 'name' => 'openid'],
            ['data' => 'nickname', 'name' => 'nickname'],
            ['data' => 'country', 'name' => 'country'],
            ['data' => 'province', 'name' => 'province'],
            ['data' => 'city', 'name' => 'city'],
            ['data' => 'gender', 'name' => 'gender'],
            ['data' => 'language', 'name' => 'language'],
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
        $this->setAjaxUrl(route('admin::miniprograms.toubar.user.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->text('nickname', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(4, form()->text('country', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(5, form()->text('province', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(6, form()->text('city', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(7, form()->select('gender', [
                'without_trashed' => trans('webed-core::datatables.select') . '...',
                1 => trans('男'),
                2 => trans('女'),
            ], null, ['class' => 'form-control form-filter input-sm']))
            ->addFilter(8, form()->text('language', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(11, form()->text('created_by', '', [
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
            ->rawColumns(['actions','nickname','country','province','city','gender','language','status','created_by'])
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
            ->filterColumn('nickname', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('nickname', '=', $keyword);
            })
            ->filterColumn('country', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('country', '=', $keyword);
            })
            ->filterColumn('province', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('province', '=', $keyword);
            })
            ->filterColumn('city', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('city', '=', $keyword);
            })
            ->filterColumn('gender', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('gender', '=', $keyword);
            })
            ->filterColumn('language', function ($query, $keyword) {
                if ($keyword == 'without_trashed') {
                    return $query->whereNull('delete_time');
                }
                return $query->whereNull('delete_time')->where('language', '=', $keyword);
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
                $activeLink = route('admin::miniprograms.toubar.user.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::miniprograms.toubar.user.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::miniprograms.toubar.user.delete.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::miniprograms.toubar.user.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);
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
            if (!has_permissions(get_current_logged_user(), ['update-user'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['delete-user'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }

                    $action = app(DeleteWXTBUserAction::class);

                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 1:
                case 0:
                    $action = app(UpdateWXTBUserAction::class);

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
