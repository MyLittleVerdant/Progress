<?php

include('classes' . DIRECTORY_SEPARATOR . 'CaptchaValue.php');

$captcha = new CaptchaValue();
$captcha_code = $captcha->generateCode();
$captcha->captchaImage($captcha_code);
