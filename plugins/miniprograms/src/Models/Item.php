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
        'telephone',
        'bp_url',
        'video_url',
        'img_url',
        'isgood',
        'isaudit',
        'type',
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

    // 修改器
    public function setVideoUrlAttribute($value){
        $video_url_ary = explode('/',$value);
        for($i=0;$i<5;$i++){
            array_shift($video_url_ary);
        }
        $video_url = implode('/',$video_url_ary);
        $this->attributes['video_url'] = $video_url;
    }
    public function setImgUrlAttribute($value){
        $img_url_ary = explode('/',$value);
        for($i=0;$i<5;$i++){
            array_shift($img_url_ary);
        }
        $img_url = implode('/',$img_url_ary);
        $this->attributes['img_url'] = $img_url;
    }
    // 读取器
    /**
     * 获取路演视频路径
     *
     * @param  string  $value
     * @return string
     */
    public function getVideoUrlAttribute($value){
        $type = $this->type;
        $tbl_base_url = config('toubar_config.video_prefix');
        $tba_base_url = config('toubar_config.tba_base_prefix');
        if($type == 1){
            if(substr($value,0,4) === 'http'){
                return $value;
            }
            return $tbl_base_url.$value;
        }elseif($type == 2) {
            return $tba_base_url . $value;
        }
    }
    /**
     * 获取路演视频缩略图路径
     *
     * @param  string  $value
     * @return string
     */
    public function getImgUrlAttribute($value){
        $type = $this->type;
        $tbl_base_url = config('toubar_config.video_prefix');
        $tba_base_url = config('toubar_config.tba_base_prefix');
        if($type == 1){
            if(substr($value,0,4) === 'http'){
                return $value;
            }
            return $tbl_base_url.$value;
        }elseif($type == 2) {
            return $tba_base_url . $value;
        }
    }

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
