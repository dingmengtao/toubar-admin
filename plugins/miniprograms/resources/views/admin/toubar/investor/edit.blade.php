@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')
    <script type="text/javascript">
        $(document).ready(function () {
            WebEd.wysiwyg($('.js-wysiwyg'));
            $('.js-select2').select2();
        });
    </script>
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
                            <b>{{ trans('Name') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input required type="text" name="post[name]"
                               class="form-control"
                               value="{{ $object->name }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('Company') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="post[company]"
                               class="form-control"
                               value="{{ $object->company }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('Job') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="post[job]"
                               class="form-control"
                               value="{{ $object->job }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('Telephone') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="post[telephone]"
                               class="form-control"
                               value="{{ $object->telephone }}" autocomplete="off">
                    </div>
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_TOUBAR_INVESTOR, $object) @endphp
        </div>
        <div class="column right">
            @include('webed-core::admin._components.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_TOUBAR_INVESTOR, $object) @endphp
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
                    {!! form()->select('post[status]', [
                       1 => trans('webed-core::base.status.activated'),
                       0 => trans('webed-core::base.status.disabled'),
                    ], $object->status, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('Isaudit') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! form()->select('post[isaudit]', [
                       0 => '未审核',
                       1 => '已审核',
                       2 => '拒绝',
                    ], $object->isaudit, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.order') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="text" name="post[order]"
                           class="form-control"
                           value="{{ $object->order ?: 0 }}" autocomplete="off">
                </div>
            </div>
            {{--@include('webed-core::admin._widgets.thumbnail', [--}}
            {{--'name' => 'post[thumbnail]',--}}
            {{--'value' => old('post.thumbnail')--}}
            {{--])--}}
            @php do_action(BASE_ACTION_META_BOXES, 'bottom-sidebar', WEBED_TOUBAR_INVESTOR, $object) @endphp
        </div>
    </div>
    {!! Form::close() !!}
@endsection
