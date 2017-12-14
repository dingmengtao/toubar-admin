<?php namespace WebEd\Plugins\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Blog\Models\Contracts\BlogTagModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class BlogTag extends BaseModel implements BlogTagModelContract
{
    use SoftDeletes;

    protected $table = 'tags';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'status',
        'order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, webed_db_prefix() . 'posts_tags', 'tag_id', 'post_id');
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
