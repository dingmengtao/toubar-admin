<?php namespace WebEd\Plugins\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Blog\Models\Contracts\NewsModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class News extends BaseModel implements NewsModelContract
{
    use SoftDeletes;

    protected $table = 'news';

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
        'type',
        'order',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
