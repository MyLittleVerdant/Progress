<?php

namespace TgRedmine\helpers;

use PHLAK\Config\Config;

class Cfg extends Singleton
{
    private $config;

    protected function __construct()
    {
        $path = dirname(dirname(__DIR__)) . '/config';
        $this->config = new Config($path, $prefix = null);
    }


    public function get($key)
    {
        return $this->config->get($key);
    }
}