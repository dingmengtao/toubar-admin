<?php namespace WebEd\Plugins\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Category extends BaseModel implements CategoryModelContract
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'slug', 'status', 'parent_id', 'page_template',
        'description', 'content', 'thumbnail', 'keywords', 'order',
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_categories', 'category_id', 'post_id');
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
}
