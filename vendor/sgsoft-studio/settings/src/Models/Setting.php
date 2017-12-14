<?php namespace WebEd\Base\Settings\Models;

use WebEd\Base\Models\EloquentBase as BaseModel;
use WebEd\Base\Settings\Models\Contracts\SettingModelContract;

class Setting extends BaseModel implements SettingModelContract
{
    protected $table = 'settings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'option_key',
        'option_value',
    ];
}
