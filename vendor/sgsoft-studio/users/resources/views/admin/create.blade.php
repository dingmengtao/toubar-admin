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
            @php
                $curentTab = request()->get('_tab', 'user_profiles');
            @endphp
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs tab-change-url">
                    <li class="{{ $curentTab === 'user_profiles' ? 'active' : '' }}">
                        <a data-target="#user_profiles"
                           data-toggle="tab"
                           href="{{ request()->url() }}?_tab=user_profiles"
                           aria-expanded="false">{{ trans('webed-users::base.user_profiles') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="user_profiles">
                        {!! form()->open(['class' => 'js-validate-form', 'url' => request()->fullUrl()]) !!}
                        {!! form()->hidden('_tab', 'user_profiles') !!}
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('webed-users::base.display_name') }}</b></label>
                            <input type="text" value="{{ old('display_name') }}"
                                   name="display_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.username') }}</b></label>
                            <input type="text" value="{{ old('username') }}"
                                   name="username"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.email') }}</b></label>
                            <input type="text" value="{{ old('email') }}"
                                   name="email"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('webed-users::base.password') }}</b></label>
                            <input type="password" value=""
                                   name="password"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('webed-users::base.first_name') }}</b></label>
                            <input type="text" value="{{ old('first_name') }}"
                                   name="first_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.last_name') }}</b></label>
                            <input type="text" value="{{ old('last_name') }}"
                                   name="last_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.phone') }}</b></label>
                            <input type="text" value="{{ old('phone') }}"
                                   name="phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.mobile_phone') }}</b></label>
                            <input type="text" value="{{ old('mobile_phone') }}"
                                   name="mobile_phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.sex') }}</b></label>
                            {!! form()->customRadio('sex', [
                                ['male', trans('webed-core::base.sex.male')],
                                ['female', trans('webed-core::base.sex.female')],
                                ['other', trans('webed-core::base.sex.other')],
                            ], old('sex', 'male')) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.status') }}</b></label>
                            {!! form()->customRadio('status', [
                                [1, trans('webed-core::base.status.activated')],
                                [0, trans('webed-core::base.status.disabled')],
                            ], old('status', 1)) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.birthday') }}</b></label>
                            <input type="text"
                                   value="{{ old('birthday') }}"
                                   name="birthday"
                                   data-date-format="yyyy-mm-dd"
                                   autocomplete="off"
                                   readonly
                                   class="form-control js-date-picker input-medium"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.description') }}</b></label>
                            <textarea class="form-control"
                                      name="description"
                                      rows="5">{!! old('description') !!}</textarea>
                        </div>
                        <div class="form-group">
                            {!! form()->selectImageBox('avatar', old('avatar')) !!}
                        </div>
                        <div class="mt10 text-right">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save') }}
                            </button>
                            <button class="btn btn-success" type="submit"
                                    name="_continue_edit" value="1">
                                <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save_and_continue') }}
                            </button>
                        </div>
                        {!! form()->close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
