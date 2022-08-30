<?php

error_reporting(E_ERROR);

include('CaptchaInterface.php');

class CaptchaField implements CaptchaInterface
{
    public function sessionWrite($code)
    {
        session_start();
        $_SESSION['captcha_field'] = $code;
    }

    public function generateCode(): string
    {
        $captcha_field = md5(uniqid('', true) . date('His'));
        $this->sessionWrite($captcha_field);

        return $captcha_field;
    }
}
