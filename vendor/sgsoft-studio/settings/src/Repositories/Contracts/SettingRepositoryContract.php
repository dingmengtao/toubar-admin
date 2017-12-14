<?php namespace WebEd\Base\Settings\Repositories\Contracts;

interface SettingRepositoryContract
{
    /**
     * @return array
     */
    public function getAllSettings();

    /**
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey);

    /**
     * @param array $settings
     * @return bool
     */
    public function updateSettings($settings = []);

    /**
     * @param $key
     * @param $value
     * @return int|null
     */
    public function updateSetting($key, $value);
}
