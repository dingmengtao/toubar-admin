<?php namespace WebEd\Plugins\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use WebEd\Plugins\Blog\Models\Contracts\NavigationModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Navigation extends BaseModel implements NavigationModelContract
{
    protected $table = 'cms_navigation';

    protected $primaryKey = 'id';

    protected $fillable = ['title','slug'];

    public $timestamps = true;

}
