<?php namespace WebEd\Base\ThemesManagement\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;

class ThemeRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator  implements ThemeRepositoryContract
{
    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
