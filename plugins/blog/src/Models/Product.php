<?php namespace WebEd\Plugins\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use WebEd\Plugins\Blog\Models\Contracts\ProductModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Product extends BaseModel implements ProductModelContract
{
    use SoftDeletes;
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'page_template',
        'slug',
        'description',
        'content',
        'thumbnail',
        'keywords',
        'status',
        'order',
        'is_featured',
        'category_id',
        'created_by',
        'updated_by',
        ];

    public $timestamps = true;
}
