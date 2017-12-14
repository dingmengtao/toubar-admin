<?php namespace WebEd\Base\Menu\Models;

use WebEd\Base\Menu\Models\Contracts\MenuNodeModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class MenuNode extends BaseModel implements MenuNodeModelContract
{
    protected $table = 'menu_nodes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'menu_id', 'parent_id', 'entity_id', 'type', 'url', 'title', 'icon_font', 'css_class', 'target', 'order',
    ];

    public $timestamps = true;

    protected $relatedModelInfo = [];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getResolvedTitleAttribute()
    {
        if ($this->title) {
            return $this->title;
        }

        if (!$this->resolveRelatedModel()) {
            return '';
        }

        return array_get($this->relatedModelInfo, 'model_title');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getResolvedUrlAttribute()
    {
        if (!$this->resolveRelatedModel()) {
            return null;
        }

        return array_get($this->relatedModelInfo, 'url');
    }

    protected function resolveRelatedModel()
    {
        if ($this->type === 'custom_link') {
            return null;
        }

        $this->relatedModelInfo = menus_management()->getObjectInfoByType($this->type, $this->entity_id);

        return $this->relatedModelInfo;
    }
}
