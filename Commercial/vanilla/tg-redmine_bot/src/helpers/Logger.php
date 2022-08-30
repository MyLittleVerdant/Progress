<?php
namespace TgRedmine\helpers;

use Monolog\Logger as Monologger;
use Monolog\Handler\RotatingFileHandler;

class Logger extends Singleton
{
    private $logger;

    public function __construct()
    {
        $path = (Cfg::getInstance())->get('path.log');
        $this->logger = new Monologger('bot');
        $this->logger->pushHandler(new RotatingFileHandler($path . 'bot.log', 2, Monologger::DEBUG));
    }

    public function log($message)
    {
        $this->logger->warning($message);
    }
}