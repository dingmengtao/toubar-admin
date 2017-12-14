<?php namespace WebEd\Plugins\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Post extends BaseModel implements PostModelContract
{
    use SoftDeletes;

    protected $table = 'posts';

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

    public function categories()
    {
        return $this->belongsToMany(Category::class, webed_db_prefix() . 'posts_categories', 'post_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, webed_db_prefix() . 'posts_tags', 'post_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }
    public function read($id){
        return $this->find($id);
    }
}
