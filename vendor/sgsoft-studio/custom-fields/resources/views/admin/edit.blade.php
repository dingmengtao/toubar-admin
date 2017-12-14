@extends('webed-core::admin._master')

@section('head')
    <link rel="stylesheet" href="{{ asset('admin/modules/custom-fields/edit-field-group.css') }}">
@endsection

@section('js')
    @include('webed-custom-fields::admin._script-templates.edit-field-group-items')
@endsection

@section('js-init')

@endsection

@section('content')
    {!! Form::open(['class' => 'js-validate-form form-update-field-group']) !!}
    <textarea name="field_group[rules]"
              id="custom_fields_rules"
              class="form-control hidden"
              style="display: none !important;">{!! $object->rules !!}</textarea>
    <textarea name="field_group[group_items]"
              id="custom_fields"
              class="form-control hidden"
              style="display: none !important;">{!! $customFieldItems or '[]' !!}</textarea>
    <textarea name="field_group[deleted_items]"
              id="deleted_items"
              class="form-control hidden"
              style="display: none !important;">{!! $deletedItems or '[]' !!}</textarea>
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.basic_info') }}</h3>
                    <div class="box-tools">
                        <a href="{{ route('admin::custom-fields.field-group.export.get', ['id' => $object->id]) }}"
                           class="btn btn-sm purple"
                           download="{{ $object->title }}">
                            <i class="fa fa-download"></i>
                            {{ trans('webed-custom-fields::base.export') }}
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.title') }}</b>
                            <span class="required"> * </span>
                        </label>
                        <input required type="text"
                               name="field_group[title]"
                               class="form-control"
                               value="{{ $object->title or '' }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.status') }}</b>
                        </label>
                        {!! form()->select('field_group[status]', [
                           1 => trans('webed-core::base.status.activated'),
                           0 => trans('webed-core::base.status.disabled'),
                        ], $object->status, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.order') }}</b>
                        </label>
                        <input required type="number"
                               name="field_group[order]"
                               class="form-control"
                               value="{{ $object->order or 0 }}"
                               autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        {{ trans('webed-custom-fields::base.form.rules.rules') }}
                    </h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="custom-fields-rules">
                        <label class="control-label mb15">
                            <b>{{ trans('webed-custom-fields::base.form.rules.rules_helper') }}</b>
                        </label>
                        <div class="line-group-container"></div>
                        <div class="line">
                            <p class="mt20"><b>{{ trans('webed-custom-fields::base.form.rules.or') }}</b></p>
                            <a class="location-add-rule-or location-add-rule btn btn-info" href="#">
                                {{ trans('webed-custom-fields::base.form.rules.add_rule_group') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="icon-layers font-dark"></i>
                {{ trans('webed-custom-fields::base.form.field_items_information') }}
            </h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                @include('webed-custom-fields::admin._partials.field-items-list')
            </div>
            <div class="text-right mt40">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save') }}
                </button>
                <button class="btn btn-success"
                        type="submit"
                        name="_continue_edit"
                        value="1">
                    <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save_and_continue') }}
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
