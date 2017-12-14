@extends('webed-core::admin._master')

@section('head')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="login-box">
        <div class="form-wrapper">
            <div class="login-logo">
                <a href="{{ get_page_link('') }}"><b>{{ config('app.name', 'WebEd') }}</b></a>
            </div>
            <div class="login-box-messages">
                <p class="login-box-msg">{{ trans('webed-users::auth.intro_message') }}</p>
                @include('webed-core::admin._partials.flash-messages')
            </div>
            <div class="login-box-body">
                {!! form()->open(['autocomplete' => 'off']) !!}
                <div class="form-group has-feedback">
                    {!! form()->text('email', null, ['class' => 'form-control input-circle input-lg', 'autocomplete' => 'off', 'placeholder' => trans('webed-users::auth.email')]) !!}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! form()->password('password', ['class' => 'form-control input-circle input-lg', 'autocomplete' => 'off', 'placeholder' => trans('webed-users::auth.password')]) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group mt20">
                    {!! form()->customCheckbox([
                        ['remember', 1, trans('webed-users::auth.remember_me')]
                    ]) !!}
                </div>
                <div class="form-group mt30">
                    {!! form()->button(trans('webed-users::auth.sign_in'), ['class' => 'btn yellow-casablanca btn-block btn-lg btn-circle', 'type' => 'submit']) !!}
                </div>
                {!! form()->close() !!}
            </div>
        </div>
    </div>
@endsection
