<?php namespace WebEd\Base\Pages\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdatePageRequest extends Request
{
    public function rules()
    {
        return [
            'page.page_template' => 'string|max:255|nullable',
            'page.title' => 'string|max:255|required',
            'page.slug' => 'string|max:255|nullable|unique:' . webed_db_prefix() . 'pages,slug,' . request()->route()->parameter('id'),
            'page.description' => 'string|max:1000|nullable',
            'page.content' => 'string|nullable',
            'page.thumbnail' => 'string|max:255|nullable',
            'page.keywords' => 'string|max:255|nullable',
            'page.status' => 'required',
            'page.order' => 'integer|min:0',
        ];
    }
}
