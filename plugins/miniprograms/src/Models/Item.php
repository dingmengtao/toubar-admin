<?php namespace WebEd\Plugins\Miniprograms\Models;

use WebEd\Plugins\Miniprograms\Models\Contracts\ItemModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Item extends BaseModel implements ItemModelContract
{
    protected $table = 'item';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'stage_id',
        'bp_url',
        'video_url',
        'img_url',
        'isgood',
        'isaudit',
        'status',
        'order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    const DELETED_AT = 'delete_time';
}
