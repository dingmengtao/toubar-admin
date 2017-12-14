@extends('webed-core::admin._master')

@section('head')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i> {{ trans('webed-core::base.form.basic_info') }}
                    </h3>
                </div>
                <div class="box-body">
                    {!! form()->open([
                        'class' => 'js-validate-form form-update-field-group',
                        'novalidate' => 'novalidate',
                        'url' => request()->fullUrl(),
                    ]) !!}
                    <div class="form-group">
                        <label class="control-label">{{ trans('webed-acl::base.form.name') }}</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('webed-acl::base.form.slug') }}</label>
                        <input type="text" name="slug"
                               value="{{ old('slug') }}"
                               class="form-control"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('webed-acl::base.form.related_permissions') }}</label>
                        <div class="scroller form-control height-auto" style="max-height: 400px;"
                             data-always-visible="1" data-rail-visible="1">
                            <div class="p10 clearfix">
                                <div class="row">
                                    @foreach($permissions as $key => $row)
                                        <div class="checkbox-group col-md-6">
                                            <label class="mt-checkbox mt-checkbox-outline">
                                                <input type="checkbox"
                                                       name="permissions[]"
                                                       {{ in_array($row->id, old('permissions', [])) ? 'checked' : '' }}
                                                       value="{{ $row->id or '' }}">
                                                @if (lang()->has($row->module . '::permissions.' . $row->slug))
                                                    {{ trans($row->module . '::permissions.' . $row->slug) }}
                                                @else
                                                    {{ $row->name }}
                                                @endif
                                                <small><b>&nbsp;({{ $row->module or '' }})</b></small>
                                                <span></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save') }}
                        </button>
                        <button class="btn btn-success" type="submit" name="_continue_edit"
                                value="1">
                            <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save_and_continue') }}
                        </button>
                    </div>
                    {!! form()->close() !!}
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_ACL_ROLE, null) @endphp
        </div>
    </div>
@endsection
