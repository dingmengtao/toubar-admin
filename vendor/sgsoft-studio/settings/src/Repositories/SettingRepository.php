<?php namespace WebEd\Base\Settings\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Settings\Repositories\Contracts\SettingRepositoryContract;

class SettingRepository extends EloquentBaseRepository implements SettingRepositoryContract
{
    /**
     * @return array
     */
    public function getAllSettings()
    {
        $settings = $this->model->get(['option_key', 'option_value']);

        return $settings->pluck('option_value', 'option_key')->toArray();
    }

    /**
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey)
    {
        $setting = $this->model
            ->where(['option_key' => $settingKey])
            ->select(['id', 'option_key', 'option_value'])
            ->first();
        if ($setting) {
            return $setting->option_value;
        }
        return null;
    }

    /**
     * @param array $settings
     * @return bool
     */
    public function updateSettings($settings = [])
    {
        foreach ($settings as $key => $row) {
            $result = $this->updateSetting($key, $row);
            if (!$result) {
                return $result;
            }
        }
        return true;
    }

    /**
     * @param $key
     * @param $value
     * @return int|null
     */
    public function updateSetting($key, $value)
    {
        /**
         * Parse everything to string
         */
        $value = (string)$value;

        $setting = $this->model
            ->where(['option_key' => $key])
            ->select(['id', 'option_key', 'option_value'])
            ->first();

        $result = $this->createOrUpdate($setting, [
            'option_key' => $key,
            'option_value' => $value
        ]);

        return $result;
    }
}
