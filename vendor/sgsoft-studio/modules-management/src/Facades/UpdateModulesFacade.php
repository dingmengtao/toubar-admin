<?php namespace WebEd\Base\ModulesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ModulesManagement\Support\UpdateModulesSupport;

/**
 * @method static registerUpdateBatches($moduleAlias, array $batches, string $type = 'plugins')
 * @method static loadBatches($moduleAlias, string $type = 'plugins')
 */
class UpdateModulesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return UpdateModulesSupport::class;
    }
}
