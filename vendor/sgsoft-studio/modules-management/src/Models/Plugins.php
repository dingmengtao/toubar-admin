<?php namespace WebEd\Base\ModulesManagement\Models;

use WebEd\Base\ModulesManagement\Models\Contracts\PluginsModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Plugins extends BaseModel implements PluginsModelContract
{
    protected $table = 'plugins';

    protected $primaryKey = 'id';

    protected $fillable = [
        'alias',
        'installed_version',
        'enabled',
        'installed',
    ];

    public $timestamps = true;

    public function setEnabledAttribute($value)
    {
        $this->attributes['enabled'] = (int)!!$value;
    }

    public function setInstalledAttribute($value)
    {
        $this->attributes['installed'] = (int)!!$value;
    }
}
