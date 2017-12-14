<div class="custom-fields-list">
    <div class="nestable-group">
        <div class="add-new-field">
            <ul class="list-group field-table-header clearfix">
                <li class="col-xs-4 list-group-item w-bold">{{ trans('webed-custom-fields::base.form.field_label') }}</li>
                <li class="col-xs-4 list-group-item w-bold">{{ trans('webed-custom-fields::base.form.field_name') }}</li>
                <li class="col-xs-4 list-group-item w-bold">{{ trans('webed-custom-fields::base.form.field_type') }}</li>
            </ul>
            <div class="clearfix"></div>
            <ul class="sortable-wrapper edit-field-group-items field-group-items"
                id="custom_field_group_items"></ul>
            <div class="text-right pt10">
                <a class="btn red btn-add-field"
                   title=""
                   href="#">{{ trans('webed-custom-fields::base.form.add_field') }}</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>