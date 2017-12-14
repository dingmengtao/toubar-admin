<?php namespace WebEd\Plugins\Blog\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreatePostRequest extends Request
{
    public function rules()
    {
        return [
            'post.page_template' => 'string|max:255|nullable',
            'post.title' => 'string|max:255|required',
            'post.slug' => 'string|max:255|unique:' . webed_db_prefix() . 'posts,slug|nullable',
            'post.description' => 'string|max:1000|nullable',
            'post.content' => 'string|nullable',
            'post.thumbnail' => 'string|max:255|nullable',
            'post.keywords' => 'string|max:255|nullable',
            'post.status' => 'required',
            'post.order' => 'integer|min:0',
            'post.is_featured' => 'integer|in:0,1',
        ];
    }
}
