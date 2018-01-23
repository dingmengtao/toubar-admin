<?php namespace WebEd\Plugins\Miniprograms\Models;

use WebEd\Plugins\Miniprograms\Models\Contracts\StageModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Stage extends BaseModel implements StageModelContract
{
    protected $table = 'stage';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
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
