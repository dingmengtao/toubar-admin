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
            <h2 class="headline">404</h2>
            <h3>{{ trans('webed-core::errors.' . Constants::NOT_FOUND_CODE . '.title') }}</h3>
            <p>{{ trans('webed-core::errors.' . Constants::NOT_FOUND_CODE . '.message') }}</p>
        </div>
    </div>
@endsection
