<?php namespace WebEd\Base\Http\Controllers;

use WebEd\Base\Facades\DashboardLanguageFacade;

class DashboardLanguageController extends BaseController
{
    protected $module = 'webed-core';

    /**
     * @param $languageSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getChangeLanguage($languageSlug)
    {
        DashboardLanguageFacade::setDashboardLanguage($languageSlug);

        return redirect()->back();
    }
}
