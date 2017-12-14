<?php namespace WebEd\Plugins\Blog\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateBlogTagRequest extends Request
{
    public function rules()
    {
        return [
            'tag.title' => 'string|max:255|required',
            'tag.slug' => 'nullable|string|max:255|unique:' . webed_db_prefix() . 'tags,slug,' . request()->route()->parameter('id'),
            'tag.status' => 'required',
            'tag.order' => 'integer|min:0',
        ];
    }
}
