<?php namespace WebEd\Plugins\Miniprograms\Models;

use WebEd\Plugins\Miniprograms\Models\Contracts\WXTBUserModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class WXTBUser extends BaseModel implements WXTBUserModelContract
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    protected $fillable = [
        'openid',
        'nickname',
        'country',
        'province',
        'city',
        'gender',
        'language',
        'extend',
        'status',
        'order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;
    protected $dateFormat = 'U';
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    const DELETED_AT = 'delete_time';
}
