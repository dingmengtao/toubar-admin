@extends('webed-core::admin._master')

@section('css')

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
                        {{ trans('webed-blog::base.categories.all') }}
                    </h3>
                    <div class="box-tools">
                        <a class="btn btn-transparent green btn-sm"
                           href="{{ route('admin::blog.categories.create.get') }}">
                            <i class="fa fa-plus"></i> {{ trans('webed-core::base.form.create') }}
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    {!! $dataTable or '' !!}
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_BLOG_CATEGORIES . '.index') @endphp
        </div>
    </div>
@endsection
