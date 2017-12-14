<?php namespace WebEd\Base\ModulesManagement\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\ModulesManagement\Repositories\Contracts\PluginRepositoryContract;

class PluginRepository extends EloquentBaseRepository implements PluginRepositoryContract
{
    /**
     * @param $alias
     * @return mixed|null
     */
    public function getByAlias($alias)
    {
        return $this->model->where('alias', '=', $alias)->first();
    }
}
