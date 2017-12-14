<?php namespace WebEd\Base\Menu\Repositories\Contracts;

use Illuminate\Support\Collection;
use WebEd\Base\Menu\Models\Contracts\MenuModelContract;

interface MenuNodeRepositoryContract
{
    /**
     * @param int $menuId
     * @param array $nodeData
     * @param int $order
     * @param null $parentId
     * @return int|null
     */
    public function updateMenuNode($menuId, array $nodeData, $order, $parentId = null);

    /**
     * @param MenuModelContract|int $menuId
     * @param null|int $parentId
     * @param int $level
     * @return Collection|null
     */
    public function getMenuNodes($menuId, $parentId = null, $level = 0);
}
