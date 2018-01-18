<?php namespace WebEd\Plugins\Share\Models;

use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Share\Models\Contracts\ShareModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Share extends BaseModel implements ShareModelContract
{
    protected $table = 'share';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'link_url',
//        'icon_url',
        'thumbnail',
        'status',
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
