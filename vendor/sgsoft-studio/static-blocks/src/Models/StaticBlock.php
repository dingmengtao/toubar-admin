<?php namespace WebEd\Base\StaticBlocks\Models;

use WebEd\Base\StaticBlocks\Models\Contracts\StaticBlockModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class StaticBlock extends BaseModel implements StaticBlockModelContract
{
    protected $table = 'static_blocks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];

    public $timestamps = true;

    /**
     * @access $this->shortcode_alias
     * @return null|string
     */
    public function getShortcodeAliasAttribute()
    {
        if ($this->slug) {
            return generate_shortcode('static_block', ['alias' => $this->slug]);
        }
        return null;
    }
}
