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
            <ul class="list-group">
                @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_SETTINGS . '.index', null) @endphp
                @foreach(cms_settings()->export() as $key => $row)
                    <li class="list-group-item
                        {{ (!request()->exists('_tab') && $loop->first === true) || request()->get('_tab') === $key ? 'active' : '' }}"
                        data-priority="{{ $row['priority'] or '' }}"
                        role="presentation">
                        <a href="{{ request()->url() }}?_tab={{ $key }}">
                            {{ $row['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="column main">
            <div class="tab-content">
                @foreach(cms_settings()->export() as $key => $group)
                    @if((!request()->exists('_tab') && $loop->first === true) || request()->get('_tab') === $key)
                    <div class="tab-pane active">
                        {!! form()->open(['class' => 'js-validate-form']) !!}
                        {!! form()->hidden('_tab', $key) !!}
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="icon-layers font-dark"></i>
                                    {{ $group['title'] }}
                                </h3>
                            </div>
                            <div class="box-body">
                                @foreach($group['items'] as $setting)
                                    <div class="form-group" data-priority="{{ $setting['priority'] or '' }}">
                                        <label class="control-label block">{{ $setting['label'] or '' }}</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('{{ $setting['name'] }}')</code>
                                            </small>
                                        </p>
                                        {!! call_user_func_array([form(), $setting['type']], call_user_func($setting['params'])) !!}
                                        <span class="help-block">{!! $setting['helper'] or '' !!}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="box-footer">
                                {!! form()->button(trans('webed-core::base.form.save_change'), [
                                    'class' => 'btn green pull-right',
                                    'type' => 'submit',
                                ]) !!}
                            </div>
                        </div>
                        {!! form()->close() !!}
                    </div>
                    @endif
                @endforeach
                @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_SETTINGS . '.index', null) @endphp
            </div>
        </div>
    </div>
@endsection
