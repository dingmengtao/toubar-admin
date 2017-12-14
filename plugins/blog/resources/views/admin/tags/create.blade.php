@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    {!! Form::open(['class' => 'js-validate-form']) !!}
    <div class="layout-2columns sidebar-right">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.basic_info') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.title') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input required type="text" name="tag[title]"
                               class="form-control"
                               value="{{ old('tag.title') }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.slug') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="tag[slug]"
                               class="form-control"
                               value="{{ old('tag.slug') }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.order') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="number" name="tag[order]"
                               class="form-control"
                               value="{{ old('tag.order', 0) }}" autocomplete="off">
                    </div>
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_BLOG_TAGS, null) @endphp
        </div>
        <div class="column right">
            @include('webed-core::admin._components.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_BLOG_TAGS, null) @endphp
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.status') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! form()->select('tag[status]', [
                       1 => trans('webed-core::base.status.activated'),
                       0 => trans('webed-core::base.status.disabled'),
                    ], old('tag.status'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
