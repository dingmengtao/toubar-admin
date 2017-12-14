<?php namespace WebEd\Base\CustomFields\Models;

use WebEd\Base\CustomFields\Models\Contracts\FieldGroupModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class FieldGroup extends BaseModel implements FieldGroupModelContract
{
    protected $table = 'field_groups';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order',
        'rules',
        'title',
        'status',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fieldItems()
    {
        return $this->hasMany(FieldItem::class, 'field_group_id');
    }
}
