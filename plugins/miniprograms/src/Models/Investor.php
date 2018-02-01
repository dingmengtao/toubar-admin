<?php namespace WebEd\Plugins\Miniprograms\Models;

use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Miniprograms\Models\Contracts\InvestorModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Investor extends BaseModel implements InvestorModelContract
{
    protected $table = 'investor';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'job',
        'telephone',
        'img_url',
        'identify_one_url',
        'identify_two_url',
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
    public function setImgUrlAttribute($value){
        $img_url_ary = explode('/',$value);
        for($i=0;$i<5;$i++){
            array_shift($img_url_ary);
        }
        $img_url = implode('/',$img_url_ary);
        $this->attributes['img_url'] = $img_url;
    }
    public function setIdentifyOneUrlAttribute($value){
        $identify_one_url_ary = explode('/',$value);
        for($i=0;$i<5;$i++){
            array_shift($identify_one_url_ary);
        }
        $identify_one_url = implode('/',$identify_one_url_ary);
        $this->attributes['identify_one_url'] = $identify_one_url;
    }
    // 读取器
    /**
     * 获取投资人头像路径
     *
     * @param  string  $value
     * @return string
     */
    public function getImgUrlAttribute($value){
        $type = $this->type;
        $tbl_base_url = 'http://toubar-localhost.me/uploadfile/images/';
        $tba_base_url = 'http://toubar-admin.me';
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
     * 获取投资人名片路径
     *
     * @param  string  $value
     * @return string
     */
    public function getIdentifyOneUrlAttribute($value){
        $type = $this->type;
        $tbl_base_url = 'http://toubar-localhost.me/uploadfile/images/';
        $tba_base_url = 'http://toubar-admin.me';
        if($type == 1){
            if(substr($value,0,4) === 'http'){
                return $value;
            }
            return $tbl_base_url.$value;
        }elseif($type == 2) {
            return $tba_base_url . $value;
        }
    }

    // 关联微信用户表
    public function investor_wxtbuser(){
        return $this->belongsTo(WXTBUser::class,'user_id');
    }
    // 关联关注行业
    public function investor_trades(){
        return $this->belongsToMany(Trade::class,webed_db_prefix().'investor_trade','investor_id','trade_id');
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
