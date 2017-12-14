@extends('webed-core::admin._master')

@section('head')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-2columns sidebar-left">
        <div class="column left">
            @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_USERS, $object) @endphp
            @include('webed-users::admin._partials._profile-sidebar')
            @php do_action(BASE_ACTION_META_BOXES, 'bottom-sidebar', WEBED_USERS, $object) @endphp
        </div>
        <div class="column main">
            @php
                $curentTab = Request::get('_tab', 'user_profiles');
            @endphp
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs tab-change-url">
                    <li class="{{ $curentTab === 'user_profiles' ? 'active' : '' }}">
                        <a data-target="#user_profiles"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=user_profiles"
                           aria-expanded="false">{{ trans('webed-users::base.user_profiles') }}</a>
                    </li>
                    <li class="{{ $curentTab === 'change_avatar' ? 'active' : '' }}">
                        <a data-target="#change_avatar"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=change_avatar"
                           aria-expanded="false">{{ trans('webed-users::base.avatar') }}</a>
                    </li>
                    <li class="{{ $curentTab === 'change_password' ? 'active' : '' }}">
                        <a data-target="#change_password"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=change_password"
                           aria-expanded="false">{{ trans('webed-users::base.password') }}</a>
                    </li>
                    @if(!$isLoggedInUser && isset($roles))
                        <li class="{{ $curentTab === 'roles' ? 'active' : '' }}">
                            <a data-target="#roles"
                               data-toggle="tab"
                               href="{{ Request::url() }}?_tab=roles"
                               aria-expanded="false">{{ trans('webed-users::base.roles') }}</a>
                        </li>
                    @endif
                    @php do_action(BASE_ACTION_META_BOXES, 'user-tab-links', WEBED_USERS, $object) @endphp
                </ul>
                <div class="tab-content">
                    <div class="tab-pane {{ $curentTab === 'user_profiles' ? 'active' : '' }}" id="user_profiles">
                        {!! form()->open(['class' => 'js-validate-form']) !!}
                        {!! form()->hidden('_tab', 'user_profiles') !!}
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('webed-users::base.display_name') }}</b></label>
                            <input type="text" value="{{ $object->display_name or '' }}"
                                   name="display_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        @if((!isset($object->id)) || !$object->id)
                            <div class="form-group">
                                <label class="control-label "><b>{{ trans('webed-users::base.password') }}</b></label>
                                <input type="text" value=""
                                       name="password"
                                       autocomplete="off"
                                       class="form-control"/>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('webed-users::base.first_name') }}</b></label>
                            <input type="text" value="{{ $object->first_name or '' }}"
                                   name="first_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.last_name') }}</b></label>
                            <input type="text" value="{{ $object->last_name or '' }}"
                                   name="last_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.phone') }}</b></label>
                            <input type="text" value="{{ $object->phone or '' }}"
                                   name="phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.mobile_phone') }}</b></label>
                            <input type="text" value="{{ $object->mobile_phone or '' }}"
                                   name="mobile_phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.sex') }}</b></label>
                            @php
                                $selected = isset($object->sex) ?  $object->sex : 'female';
                            @endphp
                            {!! form()->customRadio('sex', [
                                ['male', trans('webed-core::base.sex.male')],
                                ['female', trans('webed-core::base.sex.female')],
                                ['other', trans('webed-core::base.sex.other')],
                            ], $selected) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('webed-users::base.birthday') }}</b></label>
                            <input type="text"
                                   value="{{ isset($object->birthday) && $object->birthday ? convert_timestamp_format($object->birthday, 'Y-m-d') : '' }}"
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
                                      rows="5">{!! $object->description or '' !!}</textarea>
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
                    <div class="tab-pane {{ $curentTab === 'change_avatar' ? 'active' : '' }}" id="change_avatar">
                        {!! form()->open(['class' => 'js-validate-form']) !!}
                        {!! form()->hidden('_tab', 'change_avatar') !!}
                        <div class="form-group">
                            {!! form()->selectImageBox('avatar', (isset($object->avatar) ? $object->avatar : '')) !!}
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
                    <div class="tab-pane {{ $curentTab === 'change_password' ? 'active' : '' }}" id="change_password">
                        {!! form()->open(['class' => 'js-validate-form', 'url' => route('admin::users.update-password.post', ['id' => $object->id])]) !!}
                        {!! form()->hidden('_tab', 'change_password') !!}
                        @if($isLoggedInUser || (!$isLoggedInUser && !has_permissions($loggedInUser, ['edit-other-users'])))
                            <div class="form-group">
                                <label>
                                    <b>
                                        {{ trans('webed-users::base.old_password') }}
                                        <span class="text-danger">(*)</span>
                                    </b>
                                </label>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                    {!! form()->password('old_password', [
                                        'class' => 'form-control',
                                        'id' => 'old_password',
                                        'autocomplete' => 'off',
                                    ]) !!}
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>
                                <b>
                                    {{ trans('webed-users::base.new_password') }} <span class="text-danger">(*)</span>
                                </b>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                {!! form()->password('password', [
                                    'class' => 'form-control',
                                    'id' => 'password',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <b>
                                    {{ trans('webed-users::base.confirmation') }} <span class="text-danger">(*)</span>
                                </b>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                {!! form()->password('password_confirmation', [
                                    'class' => 'form-control',
                                    'id' => 'password_confirmation',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
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
                    @if(!$isLoggedInUser && isset($roles))
                        <div class="tab-pane {{ $curentTab === 'roles' ? 'active' : '' }}" id="roles">
                            {!! form()->open(['class' => 'js-validate-form']) !!}
                            {!! form()->hidden('_tab', 'roles') !!}
                            <div class="form-group">
                                <div class="scroller form-control height-auto"
                                     style="height: 400px;"
                                     data-always-visible="1"
                                     data-rail-visible1="1">
                                    <div class="pad-top-5 pad-bot-5 pad-left-5">
                                        {!! form()->customCheckbox($roles) !!}
                                    </div>
                                </div>
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
                    @endif
                    @php do_action(BASE_ACTION_META_BOXES, 'user-tab-pane', WEBED_USERS, $object) @endphp
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_USERS, $object) @endphp
        </div>
    </div>
@endsection
