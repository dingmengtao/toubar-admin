<?php namespace WebEd\Base\Users\Mails;

use WebEd\Base\Mails\BaseMail;

class ResetPasswordMail extends BaseMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(config('webed-auth.front_actions.forgot_password.email_template'));
    }
}
