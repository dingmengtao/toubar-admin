<?php namespace WebEd\Base\ThemesManagement\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;

class ThemeRepository extends EloquentBaseRepository implements ThemeRepositoryContract
{
    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return $this->where('alias', '=', $alias)->first();
    }
}
