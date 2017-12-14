<?php namespace WebEd\Base\ACL\Http\DataTables;

use WebEd\Base\ACL\Actions\DeleteRoleAction;
use WebEd\Base\ACL\Models\Role;
use WebEd\Base\Http\DataTables\AbstractDataTables;

class RolesListDataTable extends AbstractDataTables
{
    /**
     * @var Role
     */
    protected $model;

    /**
     * @var string
     */
    protected $screenName = WEBED_ACL_ROLE;

    public function __construct()
    {
        $this->model = do_filter(
            FRONT_FILTER_DATA_TABLES_MODEL,
            Role::select('id', 'name', 'slug'),
            $this->screenName
        );
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'name' => [
                'title' => trans('webed-acl::datatables.role.heading.name'),
                'width' => '50%',
            ],
            'slug' => [
                'title' => trans('webed-acl::datatables.role.heading.slug'),
                'width' => '30%',
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
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setAjaxUrl(route('admin::acl-roles.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('name', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->text('slug', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]));

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'deleted' => trans('webed-core::datatables.delete_these_items'),
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
                return form()->customCheckbox([
                    ['id[]', $item->id]
                ]);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $deleteLink = route('admin::acl-roles.delete.post', ['id' => $item->id]);
                $editLink = route('admin::acl-roles.edit.get', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to($editLink, trans('webed-core::datatables.edit'), ['class' => 'btn btn-outline green btn-sm']);
                $deleteBtn = form()->button(trans('webed-core::datatables.delete'), [
                    'title' => trans('webed-core::datatables.delete_this_item'),
                    'data-ajax' => $deleteLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]);

                return $editBtn . $deleteBtn;
            });
    }

    /**
     * @return array
     */
    protected function groupAction(): array
    {
        $request = request();

        $data = [];
        if ($request->input('customActionType', null) == 'group_action') {
            if(!has_permissions(get_current_logged_user(), ['delete-roles'])) {
                return [
                    'customActionMessage' => trans(WEBED_ACL . '::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$request->input('id', []);

            $action = app(DeleteRoleAction::class);
            foreach ($ids as $id) {
                $action->run($id);
            }

            $data['customActionMessage'] = trans(WEBED_ACL . '::base.delete_role_success');
            $data['customActionStatus'] = 'success';
        }
        return $data;
    }
}
