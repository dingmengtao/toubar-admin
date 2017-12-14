<?php namespace WebEd\Base\ThemesManagement\Models;

use WebEd\Base\ThemesManagement\Models\Contracts\ThemeOptionModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class ThemeOption extends BaseModel implements ThemeOptionModelContract
{
    protected $table = 'theme_options';

    protected $primaryKey = 'id';

    protected $fillable = [
        'theme_id',
        'key',
        'value'
    ];

    public $timestamps = false;

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
