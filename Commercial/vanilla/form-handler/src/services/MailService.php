<?php

namespace FormHandler\services;

use FormHandler\models\Mail;

ini_set('default_charset', 'UTF-8');
ini_set('display_errors', E_ALL);

class MailService
{
    public static function sendMail($username, $password, $from, $fromName, $to, $subject, $message, $html)
    {
        $mailer = new Mail();
        return $mailer->send($username, $password, $from, $fromName, $to, $subject, $message, $html);
    }
}