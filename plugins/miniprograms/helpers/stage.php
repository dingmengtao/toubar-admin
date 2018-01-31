<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-01-31
 * Time: 16:42
 */

use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\StageRepository;

if (!function_exists('get_stages')) {
    /**
     * @param array $args
     * @param bool $withTrash
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|mixed
     */
    function get_stages(array $args = [], $withTrash = false)
    {
        /**
         * @var StageRepository $repo
         */
        $repo = app(StageRepositoryContract::class);
        $stages = $repo->getStages(array_merge($args, [
            'order_by' => [
                'order' => 'ASC',
                'create_time' => 'DESC'
            ],
        ]), $withTrash);

        return $stages;
    }
}
