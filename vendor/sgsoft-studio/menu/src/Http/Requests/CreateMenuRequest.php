<?php namespace WebEd\Base\Menu\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreateMenuRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'string|max:255|required',
            'slug' => 'string|max:255|nullable||unique:' . webed_db_prefix() . 'menus,slug',
            'status' => 'required',
            'menu_structure' => 'required',
            'deleted_nodes' => 'required'
        ];
    }
}
