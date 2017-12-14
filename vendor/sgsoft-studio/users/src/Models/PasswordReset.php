<?php namespace WebEd\Base\Users\Models;

use WebEd\Base\Users\Models\Contracts\PasswordResetModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class PasswordReset extends BaseModel implements PasswordResetModelContract
{
    protected $table = 'password_resets';

    protected $primaryKey = 'id';

    protected $fillable = ['email', 'token', 'expired_at'];

    public $timestamps = true;
}
