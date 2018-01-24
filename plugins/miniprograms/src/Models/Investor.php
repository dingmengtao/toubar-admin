<?php namespace WebEd\Plugins\Miniprograms\Models;

use WebEd\Plugins\Miniprograms\Models\Contracts\InvestorModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Investor extends BaseModel implements InvestorModelContract
{
    protected $table = 'investor';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'job',
        'telephone',
        'img_url',
        'identify_one_url',
        'identify_two_url',
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
