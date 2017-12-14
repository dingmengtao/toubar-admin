<?php namespace WebEd\Base\ThemesManagement\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;

class ThemeOptionRepository extends EloquentBaseRepository implements ThemeOptionRepositoryContract
{
    /**
     * @var mixed|null
     */
    protected $currentTheme;

    /**
     * @param $id
     * @return array
     */
    public function getOptionsByThemeId($id)
    {
        $query = $this->model
            ->join(webed_db_prefix() . 'themes', webed_db_prefix() . 'theme_options.theme_id', '=', webed_db_prefix() . 'themes.id')
            ->where(webed_db_prefix() . 'themes.id', '=', $id)
            ->select(webed_db_prefix() . 'theme_options.key', webed_db_prefix() . 'theme_options.value')
            ->get();
        return $query->pluck('value', 'key')->toArray();
    }

    /**
     * @param $alias
     * @return array
     */
    public function getOptionsByThemeAlias($alias)
    {
        $query = $this->model
            ->join(webed_db_prefix() . 'themes', webed_db_prefix() . 'theme_options.theme_id', '=', webed_db_prefix() . 'themes.id')
            ->where(webed_db_prefix() . 'themes.alias', '=', $alias)
            ->select(webed_db_prefix() . 'theme_options.key', webed_db_prefix() . 'theme_options.value')
            ->get();
        return $query->pluck('value', 'key')->toArray();
    }

    /**
     * @param array $options
     * @return bool
     */
    public function updateOptions($options = [])
    {
        foreach ($options as $key => $row) {
            $result = $this->updateOption($key, $row);
            if (!$result) {
                return $result;
            }
        }
        return true;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateOption($key, $value)
    {
        if (!$this->currentTheme) {
            $this->currentTheme = cms_theme_options()->getCurrentTheme();
        }

        if (!$this->currentTheme) {
            return false;
        }

        $option = $this->model
            ->where([
                'key' => $key,
                'theme_id' => array_get($this->currentTheme, 'id'),
            ])
            ->select(['id', 'key', 'value'])
            ->first();

        $result = $this->createOrUpdate($option, [
            'key' => $key,
            'value' => $value,
            'theme_id' => array_get($this->currentTheme, 'id'),
        ]);

        if (!$result) {
            return false;
        }

        return true;
    }
}
