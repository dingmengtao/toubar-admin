@extends('webed-core::admin._master')

@section('head')

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
                    <h3 class="box-title">
                        {{ trans('webed-core::base.form.basic_info') }}
                    </h3>
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
                        <input required type="text" name="post[title]"
                               class="form-control"
                               value="{{ old('post.title') }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>Link_url</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="post[link_url]"
                               class="form-control"
                               value="{{ old('post.link_url') }}" autocomplete="off">
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label">--}}
                            {{--<b>Icon_url</b>--}}
                            {{--<span class="required">*</span>--}}
                        {{--</label>--}}
                        {{--<input type="text" name="post[icon_url]"--}}
                               {{--class="form-control"--}}
                               {{--value="{{ old('post.icon_url') }}" autocomplete="off">--}}
                    {{--</div>--}}
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_SHARE, null) @endphp
        </div>
        <div class="column right">
            @include('webed-core::admin._components.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_SHARE, null) @endphp
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
                    ], old('post.status'), ['class' => 'form-control']) !!}
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
                           value="{{ old('post.order', 0) }}" autocomplete="off">
                </div>
            </div>
            @include('webed-core::admin._widgets.thumbnail', [
                'name' => 'post[thumbnail]',
                'value' => old('post.thumbnail')
            ])
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.is_featured') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! form()->customRadio('post[is_featured]', [
                        [0, trans('webed-blog::base.posts.form.featured_no')],
                        [1, trans('webed-blog::base.posts.form.featured_yes')]
                    ], old('post.is_featured', 0)) !!}
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'bottom-sidebar', WEBED_BLOG_POSTS, null) @endphp
        </div>
    </div>
    {!! Form::close() !!}
@endsection
