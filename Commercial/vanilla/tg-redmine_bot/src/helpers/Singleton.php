<?php
namespace TgRedmine\helpers;

class Singleton
{
    private static $instances = [];
    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }


    public static function getInstance($db='redmine')
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($db);
        }

        return self::$instances[$cls];
    }
}