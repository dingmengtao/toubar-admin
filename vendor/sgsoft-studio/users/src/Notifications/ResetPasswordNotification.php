<?php namespace WebEd\Base\Users\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use WebEd\Base\Users\Mails\ResetPasswordMail;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * @var array
     */
    protected $data = [];

    public function __construct($data)
    {
        parent::__construct($data['token']);

        $this->data = $data;
    }

    /**
     * @param mixed $notifiable
     * @return ResetPasswordMail
     */
    public function toMail($notifiable)
    {
        $mail = new ResetPasswordMail();

        return $mail->with($this->data);
    }
}
