<div class="box box-primary box-link-menus"
     data-type="custom-link">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="icon-layers font-dark"></i>
            {{ trans('webed-menus::base.custom_link') }}
        </h3>
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label class="control-label"><b>{{ trans('webed-menus::base.title') }}</b></label>
            <input type="text"
                   class="form-control"
                   placeholder=""
                   value=""
                   name=""
                   data-field="title"
                   autocomplete="off">
        </div>
        <div class="form-group">
            <label class="control-label"><b>{{ trans('webed-menus::base.url') }}</b></label>
            <input type="text"
                   class="form-control"
                   placeholder="http://"
                   value=""
                   name=""
                   data-field="url"
                   autocomplete="off">
        </div>
        <div class="form-group">
            <label class="control-label"><b>{{ trans('webed-menus::base.css_class') }}</b></label>
            <input type="text"
                   class="form-control"
                   placeholder=""
                   value=""
                   name=""
                   data-field="css_class"
                   autocomplete="off">
        </div>
        <div class="form-group">
            <label class="control-label"><b>{{ trans('webed-menus::base.icon_font') }}</b></label>
            <input type="text"
                   class="form-control"
                   placeholder="fa fa-times"
                   value=""
                   name=""
                   data-field="icon_font"
                   autocomplete="off">
        </div>
        <div class="form-group">
            <label class="control-label"><b>{{ trans('webed-menus::base.target_type') }}</b></label>
            <select name="" class="form-control" data-field="target">
                <option value="">{{ trans('webed-menus::base.target_type.not_set') }}</option>
                <option value="_self">{{ trans('webed-menus::base.target_type.self') }}</option>
                <option value="_blank">{{ trans('webed-menus::base.target_type.blank') }}</option>
                <option value="_parent">{{ trans('webed-menus::base.target_type.parent') }}</option>
                <option value="_top">{{ trans('webed-menus::base.target_type.top') }}</option>
            </select>
        </div>
    </div>
    <div class="box-footer text-right">
        <button class="btn btn-primary add-item"
                type="submit">
            <i class="fa fa-plus"></i> {{ trans('webed-menus::base.add') }}
        </button>
    </div>
</div>