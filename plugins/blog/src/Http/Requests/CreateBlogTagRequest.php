<?php namespace WebEd\Plugins\Blog\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreateBlogTagRequest extends Request
{
    public function rules()
    {
        return [
            'tag.title' => 'string|max:255|required',
            'tag.slug' => 'nullable|string|max:255|unique:' . webed_db_prefix() . 'tags,slug',
            'tag.status' => 'required',
            'tag.order' => 'integer|min:0',
        ];
    }
}
