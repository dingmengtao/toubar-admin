<?php namespace WebEd\Plugins\Banner\Models;

use WebEd\Plugins\Banner\Models\Contracts\BannerModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Banner extends BaseModel implements BannerModelContract
{
    protected $table = 'banner';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = false;
}
