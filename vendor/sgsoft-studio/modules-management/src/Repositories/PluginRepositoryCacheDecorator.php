<?php namespace WebEd\Base\ModulesManagement\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Base\ModulesManagement\Repositories\Contracts\PluginRepositoryContract;

class PluginRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements PluginRepositoryContract
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
