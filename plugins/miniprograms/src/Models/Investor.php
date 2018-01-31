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
