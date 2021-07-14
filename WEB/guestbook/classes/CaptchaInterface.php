<?php

interface CaptchaInterface
{
    public function sessionWrite($code);
    public function generateCode();
}
