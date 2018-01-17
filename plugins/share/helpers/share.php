<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-01-12
 * Time: 18:08
 */

use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;

if (!function_exists('get_share')) {
    /**
     * @param mixed
     */
    function get_share(array $params = [])
    {
        return app(ShareRepositoryContract::class)->getShare($params);
    }
}