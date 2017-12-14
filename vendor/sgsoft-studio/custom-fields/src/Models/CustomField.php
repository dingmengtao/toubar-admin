<?php namespace WebEd\Base\CustomFields\Models;

use WebEd\Base\CustomFields\Models\Contracts\CustomFieldModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class CustomField extends BaseModel implements CustomFieldModelContract
{
    protected $table = 'custom_fields';

    protected $primaryKey = 'id';

    protected $fillable = [
        'use_for',
        'use_for_id',
        'parent_id',
        'type',
        'slug',
        'value',
        'field_item_id',
    ];

    public $timestamps = false;

    /**
     * Get $this->resolved_value
     * @return array|mixed
     */
    public function getResolvedValueAttribute()
    {
        switch ($this->type) {
            case 'repeater':
                try {
                    return json_decode($this->value, true);
                } catch (\Exception $exception) {
                    return [];
                }
                break;
            default:
                return $this->value;
                break;
        }
    }
}
