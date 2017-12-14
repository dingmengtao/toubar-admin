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
                        <i class="icon-layers font-dark"></i>
                        {{ trans('webed-custom-fields::base.all_field_groups') }}
                    </h3>
                    <div class="box-tools">
                        <a class="btn green btn-sm"
                           href="{{ route('admin::custom-fields.field-group.create.get') }}">
                            <i class="fa fa-plus"></i> {{ trans('webed-core::base.form.create') }}
                        </a>
                        <form action="{{ route('admin::custom-fields.field-group.import.post') }}"
                              class="inline-block import-field-group">
                            {!! csrf_field() !!}
                            <input type="file"
                                   accept="application/json"
                                   class="hidden"
                                   id="import_json">
                            <label class="btn red btn-sm trigger-import" for="import_json">
                                <i class="fa fa-upload"></i>
                                {{ trans('webed-custom-fields::base.import') }}
                            </label>
                        </form>
                        <a class="btn purple btn-sm"
                           download
                           href="{{ route('admin::custom-fields.field-group.export.get') }}">
                            <i class="fa fa-download"></i>
                            {{ trans('webed-custom-fields::base.export') }}
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    {!! $dataTable or '' !!}
                </div>
            </div>
        </div>
        @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_CUSTOM_FIELDS . '.index') @endphp
    </div>
@endsection
