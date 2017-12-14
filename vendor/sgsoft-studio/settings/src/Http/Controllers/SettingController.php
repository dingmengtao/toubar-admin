<?php namespace WebEd\Base\Settings\Http\Controllers;

use WebEd\Base\Http\Controllers\BaseAdminController;

use WebEd\Base\Settings\Repositories\Contracts\SettingRepositoryContract;

class SettingController extends BaseAdminController
{
    protected $module = WEBED_SETTINGS;

    /**
     * @var \WebEd\Base\Settings\Repositories\SettingRepository
     */
    protected $repository;

    public function __construct(SettingRepositoryContract $settingRepository)
    {
        parent::__construct();

        $this->repository = $settingRepository;

        $this->middleware(function ($request, $next) {
            $this->breadcrumbs->addLink(trans($this->module . '::base.settings'), route('admin::settings.index.get'));

            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle(trans($this->module . '::base.settings'));

        $this->getDashboardMenu($this->module);

        $this->assets
            ->addStylesheets('bootstrap-tagsinput')
            ->addJavascripts('bootstrap-tagsinput');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_SETTINGS, 'index.get')->viewAdmin('index');
    }

    /**
     * Update settings
     * @method POST
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->request->except([
            '_token',
            '_tab',
        ]);

        $data = do_filter(BASE_FILTER_BEFORE_UPDATE, $data, WEBED_SETTINGS, 'edit.post');

        $result = $this->repository->updateSettings($data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_SETTINGS, $data, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        return redirect()->back();
    }
}
