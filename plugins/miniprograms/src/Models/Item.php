<?php namespace WebEd\Plugins\Miniprograms\Models;

use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Miniprograms\Models\Contracts\ItemModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Item extends BaseModel implements ItemModelContract
{
    protected $table = 'item';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'stage_id',
        'bp_url',
        'video_url',
        'img_url',
        'isgood',
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

    // 关联所属阶段
    public function item_stage(){
        return $this->belongsTo(Stage::class,'stage_id');
    }
    // 关联所关注行业
    public function item_trades(){
        return $this->belongsToMany(Trade::class,webed_db_prefix().'item_trade','item_id','trade_id');
    }

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
