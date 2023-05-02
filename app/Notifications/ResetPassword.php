<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class ResetPassword extends ResetPasswordNotification
{
    use Queueable;

    ///**
    // * @param mixed $notifiable
    // * @return MailMessage|mixed
    // */
    //public function toMail($notifiable)
    //{
    //    if (static::$toMailCallback) {
    //        return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    //    }
    //
    //    return (new MailMessage)
    //        ->view('emails.forgot-password',
    //            ['url' =>  url(config('app.url').route('password.reset', [
    //                    'token' => $this->token, '
    //                    email' => $notifiable->getEmailForPasswordReset()
    //                ], false))]);
    //}
}
