<?php namespace WebEd\Base\ModulesManagement\Repositories\Contracts;

interface PluginRepositoryContract
{
    /**
     * @param $alias
     * @return mixed|null
     */
    public function getByAlias($alias);
}
