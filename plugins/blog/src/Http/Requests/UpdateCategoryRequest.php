<?php namespace WebEd\Plugins\Blog\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateCategoryRequest extends Request
{
    public function rules()
    {
        return [
            'category.parent_id' => 'integer|min:0|nullable',
            'category.page_template' => 'string|max:255|nullable',
            'category.title' => 'string|max:255|required',
            'category.slug' => 'string|max:255|unique:' . webed_db_prefix() . 'categories,slug,' . request()->route()->parameter('id'),
            'category.description' => 'string|max:1000|nullable',
            'category.content' => 'string|nullable',
            'category.thumbnail' => 'string|max:255|nullable',
            'category.keywords' => 'string|max:255|nullable',
            'category.status' => 'required',
            'category.order' => 'integer|min:0',
        ];
    }
}
