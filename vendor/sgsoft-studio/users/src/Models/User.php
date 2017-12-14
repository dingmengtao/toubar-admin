<?php namespace WebEd\Base\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use WebEd\Base\Users\Models\Contracts\UserModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;
use WebEd\Base\ACL\Models\Traits\UserAuthorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use WebEd\Base\Users\Notifications\ResetPasswordNotification;

class User extends BaseModel implements UserModelContract, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    use UserAuthorizable;

    use SoftDeletes;

    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'username', 'email', 'password',
        'first_name', 'last_name', 'display_name',
        'sex', 'status', 'phone', 'mobile_phone', 'avatar',
        'birthday', 'description', 'disabled_until',
    ];

    /**
     * @return mixed|string
     */
    public function getUserName()
    {
        if ($this->display_name) {
            return $this->display_name;
        }
        return (($this->first_name ? $this->first_name . ' ' : '') . ($this->last_name ?: ''));
    }

    /**
     * @param $value
     * @return int
     */
    public function getIdAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Hash the password before save to database
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = str_slug($value, '_');
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $expiredDateConfig = (int)config('webed-auth.front_actions.forgot_password.link_expired_after', 30) ?: 1;

        $expiredDate = Carbon::now()->addHour($expiredDateConfig);

        $data = [
            'username' => $this->username,
            'name' => $this->getUserName(),
            'email' => $this->email,
            'link' => route('front::auth.reset_password.get', [
                'token' => $token,
            ]),
            'token' => $token,
            'expired_at' => $expiredDate,
        ];

        $this->notify(new ResetPasswordNotification($data));
    }
}
