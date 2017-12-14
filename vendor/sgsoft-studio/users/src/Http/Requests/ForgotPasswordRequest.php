<?php namespace WebEd\Base\Users\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class ForgotPasswordRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
