<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{ $count or 0 }} <small class="font-white">{{ trans('webed-modules-management::base.plugins') }}</small></h3>
            <p>{{ trans('webed-core::base.status.activated') }}: <b>{{ get_plugin()->where('activated', true)->count() }}</b></p>
        </div>
        <div class="icon">
            <i class="icon-paper-plane"></i>
        </div>
        <a href="{{ route('admin::plugins.index.get') }}" class="small-box-footer">
            {{ trans('webed-core::base.stat_box.more_info') }} <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
