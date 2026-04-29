<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'reset'     => 'Your password has been reset.',
    'sent'      => 'We have emailed your password reset link.',
    'throttled' => 'Please wait before retrying.',
    'token'     => 'This password reset token is invalid.',
    'user'      => 'We can\'t find a user with that email address.',
    'failed'    => 'We were unable to send the password reset link. Please try again later.',

    // ── Reset email content ───────────────────────────────────────────
    'email_subject' => 'Reset Password',
    'email_intro'   => 'You are receiving this email because we received a password reset request for your account.',
    'email_action'  => 'Reset Password',
    'email_expire'  => 'This password reset link will expire in :count minutes.',
    'email_noreply' => 'If you did not request a password reset, no further action is required.',

];
