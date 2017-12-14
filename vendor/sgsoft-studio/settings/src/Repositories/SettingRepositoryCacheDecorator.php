<?php namespace WebEd\Base\Settings\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use WebEd\Base\Settings\Repositories\Contracts\SettingRepositoryContract;

class SettingRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements SettingRepositoryContract
{
    /**
     * @return array
     */
    public function getAllSettings()
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $settings
     * @return bool
     */
    public function updateSettings($settings = [])
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $key
     * @param $value
     * @return int|null
     */
    public function updateSetting($key, $value)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
