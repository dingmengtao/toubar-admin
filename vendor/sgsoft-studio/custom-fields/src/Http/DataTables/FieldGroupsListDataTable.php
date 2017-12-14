<?php namespace WebEd\Base\CustomFields\Http\DataTables;

use WebEd\Base\CustomFields\Actions\DeleteCustomFieldAction;
use WebEd\Base\CustomFields\Actions\UpdateCustomFieldAction;
use WebEd\Base\CustomFields\Models\FieldGroup;
use WebEd\Base\Http\DataTables\AbstractDataTables;

class FieldGroupsListDataTable extends AbstractDataTables
{
    protected $model;

    protected $screenName = WEBED_CUSTOM_FIELDS;

    public function __construct()
    {
        $this->model = do_filter(
            FRONT_FILTER_DATA_TABLES_MODEL,
            FieldGroup::select(['id', 'title', 'status', 'order', 'created_at', 'updated_at']),
            $this->screenName
        );
    }

    public function headings(): array
    {
        return [
            'title' => [
                'title' => trans('webed-core::datatables.heading.title'),
                'width' => '25%',
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
            'updated_at' => [
                'title' => trans('webed-core::datatables.heading.updated_at'),
                'width' => '10%',
            ],
            'actions' => [
                'title' => trans('webed-core::datatables.heading.actions'),
                'width' => '20%',
            ],
        ];
    }

    public function columns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'order', 'name' => 'order', 'searchable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'updated_at', 'name' => 'updated_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::custom-fields.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->select('status', [
                '' => trans('webed-core::datatables.select') . '...',
                1 => trans('webed-core::base.status.activated'),
                0 => trans('webed-core::base.status.disabled'),
            ], null, ['class' => 'form-control form-filter input-sm']));

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'deleted' => trans('webed-core::datatables.delete_these_items'),
            1 => trans('webed-core::base.status.activated'),
            0 => trans('webed-core::base.status.disabled'),
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
            ->editColumn('status', function ($item) {
                $status = $item->status ? 'activated' : 'disabled';
                return html()->label(trans('webed-core::base.status.' . $status), $status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::custom-fields.field-group.update-status.post', ['id' => $item->id, 'status' => 1]);
                $disableLink = route('admin::custom-fields.field-group.update-status.post', ['id' => $item->id, 'status' => 0]);
                $deleteLink = route('admin::custom-fields.field-group.delete.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::custom-fields.field-group.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);
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
                $exportBtn = link_to(
                    route('admin::custom-fields.field-group.export.get', ['id' => $item->id]),
                    trans('webed-custom-fields::base.export'),
                    ['class' => 'btn btn-sm btn-outline purple', 'download' => $item->title]
                );

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn . $exportBtn;
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
            if (!has_permissions(get_current_logged_user(), ['edit-field-groups'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);
            $actionValue = $request->input('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!has_permissions(get_current_logged_user(), ['delete-field-groups'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }

                    $action = app(DeleteCustomFieldAction::class);

                    foreach ($ids as $id) {
                        $action->run($id);
                    }
                    break;
                case 1:
                case 0:
                    $action = app(UpdateCustomFieldAction::class);

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
