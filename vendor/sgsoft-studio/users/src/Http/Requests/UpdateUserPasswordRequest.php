<?php namespace WebEd\Base\Users\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateUserPasswordRequest extends Request
{
    public function rules()
    {
        $rules = [
            'password' => 'required|max:60|confirmed|min:5|string',
        ];

        if (
            get_current_logged_user_id() == request()->route()->parameter('id') ||
            (
                get_current_logged_user_id() != request()->route()->parameter('id')
                && !has_permissions(get_current_logged_user(), ['edit-other-users'])
            )
        ) {
            $rules['old_password'] = 'required|max:60|min:5|string|old_password:' . webed_db_prefix() . 'users,password,' . request()->route()->parameter('id');
        }

        return $rules;
    }
}
