<?php namespace WebEd\Base\ThemesManagement\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;

class ThemeOptionRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator  implements ThemeOptionRepositoryContract
{
    /**
     * @param $id
     * @return array
     */
    public function getOptionsByThemeId($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $alias
     * @return array
     */
    public function getOptionsByThemeAlias($alias)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $options
     * @return bool
     */
    public function updateOptions($options = [])
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateOption($key, $value)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
