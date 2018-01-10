@extends('webed-core::admin._master')

@section('head')

@endsection

@section('js')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        {{ trans('webed-blog::base.navigation') }}
                    </h3>
                    <div class="box-tools">
                        <a class="btn btn-transparent green btn-sm"
                           href="{{ route('admin::blog.navigation.create.get') }}">
                            <i class="fa fa-plus"></i> {{ trans('webed-blog::base.navigation') }}
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! $dataTable or '' !!}
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_BLOG_POSTS . '.index') @endphp
    </div>
@endsection
