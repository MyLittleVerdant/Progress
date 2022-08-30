<?php

error_reporting(E_ERROR);

class CaptchaVerify
{

    private $captcha_value = '';
    private $captcha_field = '';
    private $answer_time = '';

    private function sessionRead()
    {
        session_start();

        $this->captcha_value = $_SESSION['captcha_value'];
        $this->captcha_field = $_SESSION['captcha_field'];
        $this->answer_time = $_SESSION['answer_time'];
    }


    public function verifyCode()
    {
        $this->sessionRead();


        if (isset($_SESSION[$_SERVER['REMOTE_ADDR']]) && $_SESSION[$_SERVER['REMOTE_ADDR']] >= 10) {
            echo json_encode('You have entered too many incorrect captchas!');
        } elseif (!empty($this->captcha_value) && !empty($this->captcha_field) && !empty($this->answer_time)) {
            $this->current_time = strtotime(date('d-m-Y H:i:s'));

            if ($this->current_time - $this->answer_time < 3) {
                echo json_encode('Too fast!');
            } elseif ($_POST[$this->captcha_field] == '') {
                echo json_encode('Required field!');
            } elseif (md5($_POST[$this->captcha_field]) == $this->captcha_value) {
                unset($_SESSION['captcha_value']);
                unset($_SESSION['captcha_field']);
                unset($_SESSION['answer_time']);
                echo json_encode('OK');
            } else {
                echo json_encode('Invalid captcha!');
            }
        }
    }
}
