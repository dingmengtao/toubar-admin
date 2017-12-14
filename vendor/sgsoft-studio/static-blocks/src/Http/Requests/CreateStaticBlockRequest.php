<?php namespace WebEd\Base\StaticBlocks\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreateStaticBlockRequest extends Request
{
    public function rules()
    {
        return [
            'static_block.title' => 'required|min:3|string|max:255',
            'static_block.slug' => 'string|max:255|nullable|unique:' . webed_db_prefix() . 'static_blocks,slug',
            'static_block.content' => 'string|required',
            'static_block.status' => 'required',
        ];
    }
}
