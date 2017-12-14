<?php namespace WebEd\Base\Menu\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Menu\Models\Menu;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use WebEd\Base\Menu\Repositories\Contracts\MenuNodeRepositoryContract;

class MenuNodeRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator  implements MenuNodeRepositoryContract
{
    /**
     * @param int $menuId
     * @param array $nodeData
     * @param int $order
     * @param null $parentId
     * @return int|null
     */
    public function updateMenuNode($menuId, array $nodeData, $order, $parentId = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param Menu|int $menuId
     * @param null|int $parentId
     * @param int $level
     * @return Collection|null
     */
    public function getMenuNodes($menuId, $parentId = null, $level = 0)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
