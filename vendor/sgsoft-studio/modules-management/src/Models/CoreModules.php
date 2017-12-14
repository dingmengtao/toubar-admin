<?php namespace WebEd\Base\ModulesManagement\Models;

use WebEd\Base\ModulesManagement\Models\Contracts\CoreModulesModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class CoreModules extends BaseModel implements CoreModulesModelContract
{
    protected $table = 'core_modules';

    protected $primaryKey = 'id';

    protected $fillable = [
        'alias',
        'installed_version',
    ];

    public $timestamps = true;
}
