<?php

include('classes' . DIRECTORY_SEPARATOR . 'CaptchaField.php');

$captcha_field = new CaptchaField();
$captcha_code = $captcha_field->generateCode();

include_once('guestbook.php');
